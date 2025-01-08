<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Member;
use App\Models\Religion;
use Illuminate\Http\Request;
use App\Models\SubChurch;
use App\Models\Occupation;

class MemberController extends Controller
{
    public function index()
    {
        $family_members = Member::with(['family', 'family.mainPerson'])
                                ->where('relationship_to_main_person', '!=', 'Main Member')
                                ->get();

        return view('AdminDashboard.members.memberlist', compact('family_members'));
    }


    public function create()
    {
        $occupation = Occupation::all(); 
        $religion = Religion::all();
        $main_persons = Member::where("relationship_to_main_person", "Main Member")
                              ->get(['id', 'member_name', 'family_no']);  
        return view('AdminDashboard.members.add_family_member', compact('main_persons', 'occupation','religion'));
    }
    

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'main_person' => 'required|exists:members,id',
            'member_name' => 'required|string|max:255',
            'nic' => 'required|string',
            'birth_date' => 'nullable|date',
            'civil_status' => 'nullable|string',
            'gender' => 'required|in:Male,Female,Other',
            'occupation' => 'nullable|string|max:255',
            'professional_quali' => 'nullable|string|max:255',
            'church_congregation' => 'nullable|string|max:255',
            'other_church_congregation' => 'nullable|string|max:255',
            'interests' => 'nullable|string',
            'optional_notes' => 'nullable|string',
            'relationship_to_main_person' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'religion' => 'nullable|string|max:255',
        ]);
    
        // Find the main person based on the provided ID
        $main_person = Member::findOrFail($validatedData['main_person']);
        
        // Find the highest family member number (excluding the main person)
        $lastFamilyMember = Member::where('family_no', $main_person->family_number)
                                  ->where('member_id', '!=', $main_person->member_id) 
                                  ->orderBy('member_id', 'desc')
                                  ->first();
    
        // If there are other family members, calculate the next available member number
        $nextMemberSuffix = $lastFamilyMember
                            ? (int)substr($lastFamilyMember->member_id, -2) + 1
                            : 2; 
        
        // Format the new member ID (FAM-0001-02 for example)
        $newMemberId = $main_person->family_no . '/' . str_pad($nextMemberSuffix, 2, '0', STR_PAD_LEFT);
    
         // Check if "Other" was selected and store the value accordingly
         $churchCongregation = $request->input('church_congregation');
         if ($churchCongregation === 'Other') {
             $churchCongregation = $request->input('other_church_congregation');
         }

        // Create the new family member with the validated data
        $member = Member::create([
            'family_no' => $main_person->family_no,
            'member_id' => $newMemberId,
            'member_name' => $validatedData['member_name'],
            'civil_status' => $request->input('civil_status'),
            'nic' => $validatedData['nic'],
            'birth_date' => $validatedData['birth_date'],
            'gender' => $request->input('gender'),
            'professional_quali' =>  $request->input('professional_quali'),
            'church_congregation' => $churchCongregation,
            'interests' =>  $request->input('interests'),
            'optional_notes' =>  $request->input('optional_notes'),
            'relationship_to_main_person' => $validatedData['relationship_to_main_person'],
            'occupation' => $validatedData['occupation'],
            'contact_info' => $validatedData['contact_info'],
            'email' => $validatedData['email'],
            'religion' => $validatedData['religion'],
            'baptized' => $request->boolean('baptized'),
            'full_member' => $request->boolean('full_member'),
            'methodist_member' => $request->boolean('methodist_member'),
            'sabbath_member' => $request->boolean('sabbath_member'),
            'held_office_in_council' => $request->boolean('held_office_in_council'),
        ]);
    
        // Redirect with a success message
        return redirect()->route('member.list')->with('success', __('Family member created successfully!'));
    }
    

    public function edit($id)
    {       
        $main_persons = Member::where("relationship_to_main_person", "Main Member")
        ->get(['id', 'member_name', 'family_no']);  
        $member = Member::findorFail($id);
        $occupation = Occupation::all(); 
        $religion = Religion::all(); 
        return view('AdminDashboard.members.edit_member', compact('member', 'main_persons', 'occupation','religion'));
    }

    public function update(Request $request, $id)
    {
        // Find the member that needs to be updated
        $member = Member::findOrFail($id);

        $family = Family::where('main_person_id', $request->main_person)->first();
        $family_no = $family ? $family->id : $member->family_no;
    
        $churchCongregation = $request->input('church_congregation');
        if ($churchCongregation === 'Other') {
            $churchCongregation = $request->input('other_church_congregation');
        }
        // Update the member details without changing member_id and family_no
        $member->update([
            'family_no' => $family_no, 
            'member_id' => $member->member_id, 
            'member_name' => $request->input('member_name'),
            'civil_status' => $request->input('civil_status'),
            'nic' => $request->input('nic'),
            'birth_date' => $request->input('birth_date'),
            'gender' => $request->input('gender'),
            'occupation' => $request->input('occupation'),
            'professional_quali' =>  $request->input('professional_quali'),
            'church_congregation' => $churchCongregation,
            'interests' =>  $request->input('interests'),
            'optional_notes' =>  $request->input('optional_notes'),
            'contact_info' => $request->input('contact_info'),
            'email' => $request->input('email'),
            'religion' => $request->input('religion'),
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
        $member = Member::findOrFail($id);
        $member->delete();
        return redirect()->route('member.list')->with('success', __('Family deleted successfully!'));
    }
}
