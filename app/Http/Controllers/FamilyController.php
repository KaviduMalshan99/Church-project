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
            'gender' => 'required|in:Male,Female,Other',
            'occupation' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'religion_if_not_catholic' => 'nullable|string|max:255',
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
            $imagePath = $request->hasFile('image')
                ? $request->file('image')->store('members', 'public')
                : null;
    
            // Create main member (FAM-0001-01 format)
            $mainMemberId = $familyNumber . '-01';
            $member = Member::create([
                'family_no' => $family->family_number, 
                'member_id' => $mainMemberId, 
                'member_name' => $request->input('member_name'),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'relationship_to_main_person' => 'Main Member',
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
    
            // Update family's main_person_id
            $family->update(['main_person_id' => $mainMemberId]);
        });
    
        return redirect()->route('family.list')->with('success', __('Family and main member created successfully!'));
    }
    
    public function edit($id)
    {
        $family = Family::findOrFail($id); 
        $member = Member::findorFail($id);
        $occupation = Occupation::all(); 
        return view('AdminDashboard.family.edit_family', compact('family','member','occupation'));
    }
    
    
    

    public function update(Request $request, $id) {
        $request->validate([
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

        DB::transaction(function () use ($request, $id) {
            // Retrieve the family instance
            $family = Family::findOrFail($id);
            // Retrieve the main member
            $member = Member::findorFail($id);
            
            // Update main member
            $member->update([
                'member_name' => $request->input('member_name'),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'relationship_to_main_person' => 'Main Member',
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
        });

        return redirect()->route('family.list')->with('success', __('Family and main member updated successfully!'));
    }

    public function destroy($id)
    {
        // Fetch the church by its ID
        $family = Family::findOrFail($id);
        $member = Member::findorFail($id);
        $family->delete();
        $member->delete();
        // Redirect back with success message
        return redirect()->route('family.list')->with('success', __('Family deleted successfully!'));
    }
}
