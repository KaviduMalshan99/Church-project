<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\SubChurch;
use App\Models\Religion;
use App\Models\Occupation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class FamilyController extends Controller
{
    public function index()
    {
        $families = Family::with('mainPerson')->paginate(25);  
        $totalFamilies = Family::count();
        return view('AdminDashboard.family.familylist', compact('families', 'totalFamilies'));
    }
    

    public function create()
    {
        $churches = SubChurch::all(); 
        $occupation = Occupation::all();
        $religion = Religion::all(); 
        return view('AdminDashboard.family.add_family', compact('churches','occupation','religion'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'nic' => 'nullable|string',
            'registered_date' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'occupation' => 'nullable|string|max:255',
            'professional_quali' => 'nullable|string|max:255',
            'church_congregation' => 'nullable|string|max:255',
            'civil_status' => 'nullable|string',
            'other_church_congregation' => 'nullable|string|max:255',
            'interests' => 'nullable|string',
            'optional_notes' => 'nullable|string',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'religion' => 'nullable|string|max:255',
            'nikaya' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        DB::transaction(function () use ($request) {
            // Generate new family number (FAM-0001 format)
            $lastFamily = Family::latest('id')->first();
            $nextFamilyNumber = $lastFamily ? ((int)str_replace('FAM-', '', $lastFamily->family_number)) + 1 : 1;
            $familyNumber = 'FAM-' . str_pad($nextFamilyNumber, 4, '0', STR_PAD_LEFT);
    
            // Create family without setting main_person_id
            $family = Family::create([
                'family_number' => $familyNumber,
            ]);
    
          // Handle image upload if provided
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName(); 
                $imagePath = $file->storeAs('members', $originalName, 'public');
            }

    
            // Check if "Other" was selected and store the value accordingly
            $churchCongregation = $request->input('church_congregation');
            if ($churchCongregation === 'Other') {
                $churchCongregation = $request->input('other_church_congregation');
            }


            // Create main member (FAM-0001-01 format)
            $mainMemberId = $familyNumber . '/01';
            $member = Member::create([
                'family_no' => $family->family_number, 
                'member_id' => $mainMemberId, 
                'member_name' => $request->input('member_name'),
                'civil_status' => $request->input('civil_status'),
                'nic' => $request->input('nic'),
                'birth_date' => $request->input('birth_date'),
                'registered_date' =>  $request->input('registered_date'),
                'gender' => $request->input('gender'),
                'occupation' => $request->input('occupation'),
                'professional_quali' =>  $request->input('professional_quali'),
                'church_congregation' => $churchCongregation,
                'interests' =>  $request->input('interests'),
                'optional_notes' =>  $request->input('optional_notes'),
                'relationship_to_main_person' => 'Main Member',
                'occupation' => $request->input('occupation'),
                'contact_info' => $request->input('contact_info'),
                'email' => $request->input('email'),
                'religion' => $request->input('religion'),
                'nikaya' => $request->input('nikaya'),
                'baptized' => $request->boolean('baptized'),
                'full_member' => $request->boolean('full_member'),
                'methodist_member' => $request->boolean('methodist_member'),
                'sabbath_member' => $request->boolean('sabbath_member'),
                'held_office_in_council' => $request->boolean('held_office_in_council'),
                'image' => $imagePath,
            ]);
    
            // Update family's main_person_id
            $family->update(['main_person_id' => $mainMemberId]);
        });
    
        return redirect()->route('family.list')->with('success', __('Family and main member created successfully!'));
    }
    
    
    public function edit($family_number)
    {
        $family = Family::where('family_number', $family_number)->firstOrFail();
        $member = Member::where('family_no', $family_number)->firstOrFail();
        $religion = Religion::all();
        $occupation = Occupation::all();
        
        return view('AdminDashboard.family.edit_family', compact('family', 'member', 'occupation', 'religion'));
    }
    
    
    

    public function update(Request $request, $family_number) {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'nic' => 'nullable|string',
            'civil_status' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'occupation' => 'nullable|string|max:255',
            'professional_quali' => 'nullable|string|max:255',
            'church_congregation' => 'nullable|string|max:255',
            'other_church_congregation' => 'nullable|string|max:255',
            'interests' => 'nullable|string',
            'optional_notes' => 'nullable|string',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'religion' => 'nullable|string|max:255',
            'nikaya' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        DB::transaction(function () use ($request, $family_number) {
            // Retrieve the family instance
            $family = Family::where('family_number', $family_number)->firstOrFail();
            $member = Member::where('family_no', $family_number)->firstOrFail();

             // Check if "Other" was selected and store the value accordingly
            $churchCongregation = $request->input('church_congregation');
            if ($churchCongregation === 'Other') {
                $churchCongregation = $request->input('other_church_congregation');
            }

            // Handle image upload and replace existing image if needed
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($member->image) {
                    Storage::delete('public/' . $member->image);
                }
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $imagePath = $file->storeAs('members', $fileName, 'public');

                $member->image = $imagePath;
            }

            // Update main member
            $member->update([
                'member_name' => $request->input('member_name'),
                'nic' => $request->input('nic'),
                'civil_status' => $request->input('civil_status'),
                'birth_date' => $request->input('birth_date'),
                'registered_date' =>  $request->input('registered_date'),
                'gender' => $request->input('gender'),
                'occupation' => $request->input('occupation'),
                'professional_quali' =>  $request->input('professional_quali'),
                'church_congregation' => $churchCongregation,
                'interests' =>  $request->input('interests'),
                'optional_notes' =>  $request->input('optional_notes'),
                'relationship_to_main_person' => 'Main Member',
                'occupation' => $request->input('occupation'),
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
        });

        return redirect()->route('family.list')->with('success', __('Family and main member updated successfully!'));
    }

    public function destroy($family_number)
    {
        // Fetch the church by its ID
        $family = Family::where('family_number', $family_number)->firstOrFail();
        $member = Member::where('family_no', $family_number)->firstOrFail();
        $family->delete();
        $member->delete();
        return redirect()->route('family.list')->with('success', __('Family deleted successfully!'));
    }
}
