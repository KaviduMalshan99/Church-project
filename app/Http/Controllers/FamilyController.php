<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\SubChurch;
use App\Models\Religion;
use App\Models\Area;
use App\Models\AcademicQualification;
use App\Models\Occupation;
use App\Models\HeldinCouncil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class FamilyController extends Controller
{
    public function index(Request $request)
{
    // Start the query
    $query = Family::with('mainPerson');

    // Apply area filter if provided
    if ($request->filled('area')) {
        $query->whereHas('mainPerson', function ($q) use ($request) {
            $q->where('area', $request->input('area'));
        });
    }

    // Filter by family_number
    if ($request->filled('family_number')) {
        $query->where('family_number', 'like', '%' . $request->input('family_number') . '%');
    }

    // Filter by main person's member_name
    if ($request->filled('member_name')) {
        $query->whereHas('mainPerson', function ($q) use ($request) {
            $q->where('member_name', 'like', '%' . $request->input('member_name') . '%');
        });
    }

    // Get total count based on filtered query
    $totalFamilies = $query->count();

    // Paginate the result
    $families = $query->paginate(25);

    // Get list of all areas for the dropdown
    $areas = Area::all();

    return view('AdminDashboard.family.familylist', compact('families', 'totalFamilies', 'areas'));
}

    

    public function create()
    {
        $churches = SubChurch::all(); 
        $occupation = Occupation::all();
        $religion = Religion::all(); 
        $academicQualifications = AcademicQualification::all(); 
        $areas = Area::all(); 
        $heldincouncil = HeldinCouncil::all();
        return view('AdminDashboard.family.add_family', compact('churches','occupation','religion','heldincouncil','academicQualifications','areas'));
    }


    public function store(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'member_name' => 'required|string|max:255',
                'member_title' => 'required|string|max:255',
                'name_with_initials' => 'required|string',
                'address' => 'required|string',
                'academic_quali' => 'nullable|string|max:255',
                'birth_date' => 'nullable|date',
                'nic' => 'nullable|string',
                'registered_date' => 'nullable|date',
                'baptized_date' => 'nullable|date',
                'married_date' => 'nullable|date',
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
                'area' => 'nullable|string|max:255',
                'held_office_in_council' => 'nullable|array',
                'held_office_in_council.*' => 'nullable|string',
                'nikaya' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            // Start transaction
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
                    'member_title' => $request->input('member_title'),
                    'member_name' => $request->input('member_name'),
                    'name_with_initials' => $request->input('name_with_initials'),
                    'address' => $request->input('address'),
                    'civil_status' => $request->input('civil_status'),
                    'nic' => $request->input('nic'),
                    'birth_date' => $request->input('birth_date'),
                    'registered_date' =>  $request->input('registered_date'),
                    'baptized_date' =>  $request->input('baptized_date'),
                    'married_date' =>  $request->input('married_date'),
                    'gender' => $request->input('gender'),
                    'occupation' => $request->input('occupation'),
                    'professional_quali' =>  $request->input('professional_quali'),
                    'church_congregation' => $churchCongregation,
                    'interests' =>  $request->input('interests'),
                    'optional_notes' =>  $request->input('optional_notes'),
                    'relationship_to_main_person' => 'Main Member',
                    'contact_info' => $request->input('contact_info'),
                    'email' => $request->input('email'),
                    'academic_quali' => $request->input('academic_quali'),
                    'religion' => $request->input('religion'),
                    'area' => $request->input('area'),
                    'nikaya' => $request->input('nikaya'),
                    'baptized' => $request->boolean('baptized'),
                    'member_status' => $request->boolean('member_status'),
                    'full_member' => $request->boolean('full_member'),
                    'half_member' => $request->boolean('half_member'),
                    'associate_member' => $request->boolean('associate_member'),
                    'methodist_member' => $request->boolean('methodist_member'),
                    'sabbath_member' => $request->boolean('sabbath_member'),
                    'held_office_in_council' => json_encode($request->input('held_office_in_council', [])),
                    'image' => $imagePath,
                ]);
    
                // Update family's main_person_id
                $family->update(['main_person_id' => $mainMemberId]);
            });
    
            return redirect()->route('family.list')->with('success', __('Family and main member created successfully!'));
        } catch (\Exception $e) {
            Log::error('Error occurred while storing family and member data: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $e,
            ]);
    
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }
    
    
    
    public function edit($family_number)
    {
        $family = Family::where('family_number', $family_number)->firstOrFail();
        $member = Member::where('family_no', $family_number)->firstOrFail();
        $religion = Religion::all();
        $occupation = Occupation::all();
        $academicQualifications = AcademicQualification::all();
        $heldincouncil = HeldinCouncil::all();
        $areas = Area::all(); 
        $existingHeldOffices = json_decode($member->held_office_in_council, true) ?: [];

        return view('AdminDashboard.family.edit_family', compact('family', 'member', 'occupation', 'religion', 
        'heldincouncil', 'academicQualifications', 'existingHeldOffices','areas'));
    }

    
    
    

    public function update(Request $request, $family_number) {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'member_title' => 'required|string|max:255',
            'name_with_initials' => 'required|string',
            'address' => 'required|string',
            'nic' => 'nullable|string',
            'civil_status' => 'nullable|string',
            'married_date' => 'nullable|date',
            'date_of_death' => 'nullable|date',
            'birth_date' => 'nullable|date',
            'baptized_date' => 'nullable|date',
            'area' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'occupation' => 'nullable|string|max:255',
            'professional_quali' => 'nullable|string|max:255',
            'church_congregation' => 'nullable|string|max:255',
            'other_church_congregation' => 'nullable|string|max:255',
            'interests' => 'nullable|string',
            'optional_notes' => 'nullable|string',
            'contact_info' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'academic_quali' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'held_office_in_council' => 'nullable|array',
            'held_office_in_council.*' => 'nullable|string',
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
                'member_title' => $request->input('member_title'),
                'name_with_initials' => $request->input('name_with_initials'),
                'address' => $request->input('address'),
                'nic' => $request->input('nic'),
                'civil_status' => $request->input('civil_status'),
                'birth_date' => $request->input('birth_date'),
                'married_date' => $request->input('civil_status') === 'Married' ? $request->input('married_date') : null,
                'registered_date' => $request->input('registered_date'),
                'date_of_death' => $request->input('date_of_death'),
                'baptized_date' => $request->boolean('baptized') ? $request->input('baptized_date') : null,
                'gender' => $request->input('gender'),
                'occupation' => $request->input('occupation'),
                'professional_quali' => $request->input('professional_quali'),
                'church_congregation' => $churchCongregation,
                'interests' => $request->input('interests'),
                'optional_notes' => $request->input('optional_notes'),
                'relationship_to_main_person' => 'Main Member',
                'occupation' => $request->input('occupation'),
                'contact_info' => $request->input('contact_info'),
                'email' => $request->input('email'),
                'academic_quali' => $request->input('academic_quali'),
                'area' => $request->input('area'),
                'religion' => $request->input('religion'),
                'nikaya' => $request->input('nikaya'),
                'baptized' => $request->boolean('baptized'),
                'member_status' => $request->boolean('member_status'),
                'full_member' => $request->boolean('full_member'),
                'half_member' => $request->boolean('half_member'),
                'associate_member' => $request->boolean('associate_member'),
                'methodist_member' => $request->boolean('methodist_member'),
                'sabbath_member' => $request->boolean('sabbath_member'),
                'held_office_in_council' => json_encode($request->input('held_office_in_council', [])),
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
