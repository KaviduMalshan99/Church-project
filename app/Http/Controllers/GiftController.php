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
        return view('AdminDashboard.gift.giftlist', compact('gifts'));
    }

    public function create()
    {
        $members = Member::all();
        return view('AdminDashboard.gift.addgift', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|exists:members,id',
            'receiver_name' => 'required|exists:members,id',
            'receiver_address' => 'required|string|max:255',
            'greeting_title' => 'required|string|max:255',
            'greeting_msg' => 'nullable|string|max:500',
        ]);

        // If validation passes, proceed to create the gift
        $gift = Gift::create([
            'gift_code' => 'GIFT-' . strtoupper(Str::uuid()),
            'sender_id' => $validated['sender_name'],
            'receiver_id' => $validated['receiver_name'],
            'receiver_address' => $validated['receiver_address'],
            'greeting_title' => $validated['greeting_title'],
            'greeting_description' => $request->greeting_msg,
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
            'sender_name' => 'required|exists:members,id',
            'receiver_name' => 'required|exists:members,id',
            'receiver_address' => 'required|string|max:255',
            'greeting_title' => 'required|string|max:255',
            'greeting_msg' => 'nullable|string|max:500',
        ]);

        $gift = Gift::findorFail($id);
        $gift->update([
            'sender_id' => $validated['sender_name'],
            'receiver_id' => $validated['receiver_name'],
            'receiver_address' => $validated['receiver_address'],
            'greeting_title' => $validated['greeting_title'],
            'greeting_description' => $request->greeting_msg,
            'gift_status' => $request->gift_status,
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
