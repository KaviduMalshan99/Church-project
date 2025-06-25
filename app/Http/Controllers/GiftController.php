<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\ContributionType;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Str;
use Carbon\Carbon; 
use App\Models\Area;
use Illuminate\Support\Facades\File;


class GiftController extends Controller
{
   public function index(Request $request)
{
    $query = Gift::query();

    // Filter by exact date
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Filter by contribution type
    if ($request->filled('contribution_type') && $request->contribution_type !== 'all') {
        $query->where('type', $request->contribution_type);
    }

    // Weekly filter: from_date to to_date
    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }

    // Monthly filter: from_month to to_month
    if ($request->filled('from_month') && $request->filled('to_month')) {
        $fromMonth = Carbon::createFromFormat('Y-m', $request->from_month)->startOfMonth();
        $toMonth = Carbon::createFromFormat('Y-m', $request->to_month)->endOfMonth();
        $query->whereBetween('created_at', [$fromMonth, $toMonth]);
    }

    // ✅ Filter by sender's area
    if ($request->filled('area')) {
        $query->whereHas('member', function ($q) use ($request) {
            $q->where('area', $request->input('area'));
        });
    }

    $gifts = $query->get();
    $totalAmount = $gifts->sum('amount');

    $contribution_types = ContributionType::all();

    $areas = Area::all();
    return view('AdminDashboard.gift.giftlist', compact('gifts', 'totalAmount', 'contribution_types', 'areas'));
}


    
    
    


    public function create()
    {
        $members = Member::all();
        $contribution_types = ContributionType::all();
        return view('AdminDashboard.gift.addgift', compact('members','contribution_types'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_id' => 'required|exists:members,member_id',
            'type' => 'required|string',
            'date' => 'nullable|date',
            'amount' => 'required|numeric',
        ]);
    
        // Get the logged-in user’s name and their signature
        $receivedBy = session('name');
        $user = \App\Models\SystemUser::where('name', $receivedBy)->first();
        $userSignature = $user ? $user->signature : null;
    
        // Create the gift entry
        $gift = Gift::create([
            'sender_id' => $validated['sender_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'received_by' => $receivedBy, 
        ]);
    
        // Generate the PDF
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);
    
        $html = view('AdminDashboard.gift.bill', compact('gift', 'receivedBy', 'userSignature'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
         // Step 5: Save PDF to Storage
    $directory = storage_path('app/public/gifts');
    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0777, true);
    }

    $pdfFilename = $gift->id . '_bill.pdf';
    $pdfPath = 'gifts/' . $pdfFilename;
    file_put_contents(storage_path('app/public/' . $pdfPath), $dompdf->output());

    
        // Save the PDF path in the database
        $gift->bill_path = $pdfPath;
        $gift->save();
    
        // Get the sender's email
        $sender = Member::where('member_id', $validated['sender_id'])->first();
        $senderEmail = $sender->email;
    
        // Send the email with the PDF attached
        Mail::to($senderEmail)->send(new \App\Mail\GiftBillMail($gift, $pdfPath));
    
        // Redirect to the gift list and pass the PDF URL to be opened
        return redirect()->route('gift.list')->with('pdf_url', asset('storage/' . $pdfPath));
    }
    
    

    
    

    public function edit($id) {        
        $gift = Gift::findorFail($id);
        $members = Member::all();
        $contribution_types = ContributionType::all();
        return view('AdminDashboard.gift.edit_gift', compact('gift', 'members','contribution_types'));
    }

    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sender_id' => 'required|exists:members,member_id',
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'nullable|date',
        ]);
    
        $gift = Gift::findOrFail($id);
        
        $receivedBy = session('name');
        $user = \App\Models\SystemUser::where('name', $receivedBy)->first();
        $userSignature = $user ? $user->signature : null;
    
        // Update the gift entry
        $gift->update([
            'sender_id' => $validated['sender_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'received_by' => $receivedBy,
        ]);
    
        // Generate the updated PDF bill
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);
    
        // Render the HTML view with the updated gift data and signature
        $html = view('AdminDashboard.gift.bill', compact('gift', 'receivedBy', 'userSignature'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Save the PDF to storage
        $pdfPath = 'gifts/' . $gift->id . '_bill.pdf';
        file_put_contents(storage_path('app/public/' . $pdfPath), $dompdf->output());
    
        // Save the PDF path in the gift entry
        $gift->bill_path = $pdfPath;
        $gift->save();
    
        $sender = Member::where('member_id', $validated['sender_id'])->first();
        $senderEmail = $sender->email;
    
        Mail::to($senderEmail)->send(new \App\Mail\GiftBillMail($gift, $pdfPath));
    
        return redirect()->route('gift.list')->with('success', 'Gift Updated Successfully')->with('pdf_url', asset('storage/' . $pdfPath));
    }
    

    public function destroy($id)
    {
        // Fetch the church by its ID
        $gift = Gift::findOrFail($id);
       
        $gift->delete();
        // Redirect back with success message
        return redirect()->route('gift.list')->with('success', __('Family deleted successfully!'));
    }
}
