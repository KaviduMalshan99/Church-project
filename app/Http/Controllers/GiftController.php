<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Str;

class GiftController extends Controller
{
    public function index()
    {
        $gifts = Gift::all();
        $kawaraTotal = $gifts->where('type', 'Kawara Pooja')->sum('amount');
        $otherTotal = $gifts->where('type', 'Other')->sum('amount');
        $totalAmount = $kawaraTotal + $otherTotal; 
        
        return view('AdminDashboard.gift.giftlist', compact('gifts', 'kawaraTotal', 'otherTotal', 'totalAmount'));
    }


    public function create()
    {
        $members = Member::all();
        return view('AdminDashboard.gift.addgift', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_id' => 'required|exists:members,member_id',
            'type' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        // If validation passes, proceed to create the gift
        $gift = Gift::create([
            'sender_id' => $validated['sender_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
        ]);

        return redirect()->route('gift.list')->with('success', 'Gift Added Successfully');
    }

    public function edit($id) {        
        $gift = Gift::findorFail($id);
        $members = Member::all();
        return view('AdminDashboard.gift.edit_gift', compact('gift', 'members'));
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
