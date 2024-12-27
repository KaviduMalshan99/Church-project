<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\SubChurch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FamilyController extends Controller
{
    public function index()
    {
        $families = Family::paginate(25);
        $totalFamilies = Family::count();
        return view('AdminDashboard.family.familylist', compact('families', 'totalFamilies'));
    }

    public function create()
    {
        $churches = SubChurch::all(); // Fetch all churches
        return view('AdminDashboard.family.add_family', compact('churches'));
    }

    public function store(Request $request)
    {

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

        DB::transaction(function () use ($request) {
            // Create family without setting main_person_id
            $family = Family::create([
                'family_name' => $request->input('family_name'),
                'family_number' => 'FAM-' . strtoupper(Str::uuid()),
            ]);

            // Handle image upload if provided
            $imagePath = $request->hasFile('image')
                ? $request->file('image')->store('members', 'public')
                : null;

            // Create main member
            $member = Member::create([
                'family_id' => $family->id,
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
            $family->update(['main_person_id' => $member->id]);
        });

        return redirect()->route('family.list')->with('success', __('Family and main member created successfully!'));
    }

    public function edit($id) {
        // dd($id);
        $family = Family::findorFail($id);
        $member = Member::findorFail($family -> main_person_id);
        $churches = SubChurch::all();
        return view('AdminDashboard.family.edit_family', compact('family', 'member', 'churches'));
    }

    public function update(Request $request, $id) {
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

        DB::transaction(function () use ($request, $id) {
            // Retrieve the family instance
            $family = Family::findOrFail($id);
            // Update family without setting main_person_id
            $family->update([
                'family_name' => $request->input('family_name'),
            ]);

           

            // Retrieve the main member
            $member = Member::findOrFail($family->main_person_id);
            
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
        $main_person = Member::findOrFail($family->main_person_id);
        // Delete the church
        $family->delete();
        $main_person->delete();
        // Redirect back with success message
        return redirect()->route('family.list')->with('success', __('Family deleted successfully!'));
    }
}
