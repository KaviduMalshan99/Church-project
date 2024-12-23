<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubChurch;

class FamilyController extends Controller
{
    public function index()
    {
        $churches = SubChurch::all(); // Fetch all churches
        return view('AdminDashboard.family.index', compact('churches'));
    }

    public function store(Request $request)
    {
        dd($request);
        // Validate the request
        $request->validate([
            'sub_church_id' => 'required|exists:sub_churches,id',
            'family_name' => 'nullable|string|max:255',
            'member_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'occupation' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'religion_if_not_catholic' => 'nullable|string|max:255',
            'nikaya' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        //dd($request);
        

        // Create the family
        $family = Family::create([
            'family_name' => $request->input('family_name'),
            'family_number' => 'FAM-' . strtoupper(uniqid()), // Generate unique family number
        ]);

        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('members', 'public');
        }

        // Create the main member and associate with the family
        $member = Member::create([
            'family_id' => $family->id,
            'member_name' => $request->input('member_name'),
            'birth_date' => $request->input('birth_date'),
            'gender' => $request->input('gender'),
            'relationship_to_main_person' =>  'Main Member',
            'occupation' => $request->input('occupation'),
            'contact_info' => $request->input('contact_info'),
            'email' => $request->input('email'),
            'religion_if_not_catholic' => $request->input('religion_if_not_catholic'),
            'nikaya' => $request->input('nikaya'),
            'baptized' => $request->boolean('baptized'),
            'full_member' => $request->boolean('full_member'),
            'methodist_member' => $request->boolean('methodist_member'),
            'sabbath_member' => $request->boolean('sabbath_member'),
            'held_office_in_council' => $request->boolean('held_office_in_council'),
            'image' => $imagePath,
        ]);

        // Update the family's main person ID
        $family->update(['main_person_id' => $member->id]);

        return redirect()->route('family.list')->with('success', 'Family and main member created successfully!');
    }

    
}
