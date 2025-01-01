<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\SubChurch;

class MemberController extends Controller
{
    public function index()
    {
        $main_members = Member::where("relationship_to_main_person", "Main Member")->get();
        $family_members = Member::where("relationship_to_main_person", "!=", "Main Member")->get();
        // dd($main_member, $family_members);
        return view('AdminDashboard.members.memberlist', compact('main_members', 'family_members'));
    }

    public function create()
    {
        $churches = SubChurch::all();
        $main_persons = Member::where("relationship_to_main_person", "Main Member")->get();
        // dd($main_persons);
        return view('AdminDashboard.members.add_family_member', compact('churches', 'main_persons'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'main_person' => 'required|exists:members,id', // Ensure the main person exists in the database
            'member_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'relationship_to_main_person' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'religion_if_not_catholic' => 'nullable|string|max:255',
            'nikaya' => 'nullable|string|max:255',
        ]);
        // Find the main person based on the provided ID
        $main_person = Member::findOrFail($validatedData['main_person']);

        // Create a new member with the validated details
        $member = Member::create([
            'family_id' => $main_person->family_id,
            'main_member_id' => $validatedData['main_person'],
            'member_name' => $validatedData['member_name'],
            'birth_date' => $validatedData['birth_date'],
            'gender' => $validatedData['gender'],
            'relationship_to_main_person' => $validatedData['relationship_to_main_person'],
            'occupation' => $validatedData['occupation'],
            'contact_info' => $validatedData['contact_info'],
            'email' => $validatedData['email'],
            'religion_if_not_catholic' => $validatedData['religion_if_not_catholic'],
            'nikaya' => $validatedData['nikaya'],
            'baptized' => $request->boolean('baptized'),
            'full_member' => $request->boolean('full_member'),
            'methodist_member' => $request->boolean('methodist_member'),
            'sabbath_member' => $request->boolean('sabbath_member'),
            'held_office_in_council' => $request->boolean('held_office_in_council'),
        ]);

        // Redirect with a success message
        return redirect()->route('member.list')->with('success', __('Family and main member created successfully!'));
    }

    public function edit($id)
    {
        // dd($id);        
        $main_persons = Member::where("relationship_to_main_person", "Main Member")->get();
        $member = Member::findorFail($id);
        $churches = SubChurch::all();
        return view('AdminDashboard.members.edit_member', compact('member', 'main_persons', 'churches'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $family = Family::where('main_person_id', $request->main_person)->first();
        $family_id = $family ? $family->id : null;
        // Ensure to handle the case where no family is found// Update main member
        $member->update([
            'family_id' => $family_id,
            'main_member_id' => $request->input('main_person'),
            'member_name' => $request->input('member_name'),
            'birth_date' => $request->input('birth_date'),
            'gender' => $request->input('gender'),
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
        ]);
        return redirect()->route('member.list')->with('success', __('Family member updated successfully!'));
    }

    public function destroy($id)
    {
        // Fetch the church by its ID
        $member = Member::findOrFail($id);
        // Delete the church
        $member->delete();
        // Redirect back with success message
        return redirect()->route('member.list')->with('success', __('Family deleted successfully!'));
    }
}
