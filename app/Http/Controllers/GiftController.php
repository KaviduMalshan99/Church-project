<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\ContributionType;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Str;

class GiftController extends Controller
{
    public function index(Request $request)
    {
        $query = Gift::query();
        
        // Filter by date if selected
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }
        
        // Filter by contribution_type if selected, except for 'all'
        if ($request->has('contribution_type') && $request->contribution_type != '' && $request->contribution_type != 'all') {
            $query->where('type', $request->contribution_type);
        }
    
        $gifts = $query->get();
        $totalAmount = $gifts->sum('amount');
    
        $contribution_types = ContributionType::all();
    
        return view('AdminDashboard.gift.giftlist', compact('gifts', 'totalAmount', 'contribution_types'));
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
            'amount' => 'required|numeric',
        ]);
    
        $gift = Gift::create([
            'sender_id' => $validated['sender_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
        ]);
    
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);
    
        $html = view('AdminDashboard.gift.bill', compact('gift'))->render();
    
        $dompdf->loadHtml($html);
    
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $pdfPath = 'gifts/' . $gift->id . '_bill.pdf';
        file_put_contents(storage_path('app/public/' . $pdfPath), $dompdf->output());
    
        $gift->bill_path = $pdfPath;
        $gift->save();
    
        return redirect()->route('gift.list')->with('success', 'Gift Added Successfully');
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
        ]);

        $gift = Gift::findorFail($id);
        $gift->update([
            'sender_id' => $validated['sender_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
        ]);

        return redirect()->route('gift.list')->with('success', 'Gift Updated Successfully');
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
