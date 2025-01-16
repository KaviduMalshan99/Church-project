<?php

namespace App\Http\Controllers;
use App\Models\Occupation;
use App\Models\Religion;
use App\Models\HeldinCouncil;
use App\Models\SystemUser;
use App\Models\ContributionType;
use Illuminate\Http\Request;
use App\Models\AcademicQualification;

class SettingsController extends Controller
{
    public function occupation()
    {
        $occupation = Occupation::all();
        return view('AdminDashboard.settings.occupation', compact('occupation'));
    }

    public function occupation_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Occupation::create($validated);

        return redirect()->route('settings.occupation')->with('success', 'occupation added successfully!');
    }


    public function occupation_destroy($id)
    {
        $occupation = Occupation::findOrFail($id);
        $occupation->delete();

        return redirect()->route('settings.occupation')->with('success', 'occupation deleted successfully!');
    }

    public function occupation_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $occupation = Occupation::findOrFail($id);
        $occupation->update($validated);

        return redirect()->route('settings.occupation')->with('success', 'Occupation updated successfully!');
    }



    public function religion()
    {
        $religion = Religion::all();
        return view('AdminDashboard.settings.religion', compact('religion'));
    }

    public function religion_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Religion::create($validated);

        return redirect()->route('settings.religion')->with('success', 'Religion added successfully!');
    }


    public function religion_destroy($id)
    {
        $religion = Religion::findOrFail($id);
        $religion->delete();

        return redirect()->route('settings.religion')->with('success', 'Religion deleted successfully!');
    }

    public function religion_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $religion = Religion::findOrFail($id);
        $religion->update($validated);

        return redirect()->route('settings.religion')->with('success', 'Religion updated successfully!');
    }



    
    public function held_in_council()
    {
        $heldincouncil = HeldinCouncil::all();
        return view('AdminDashboard.settings.held_in_council', compact('heldincouncil'));
    }


    public function held_in_council_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        HeldinCouncil::create($validated);

        return redirect()->route('settings.held_in_council')->with('success', 'Data added successfully!');
    }


    public function held_in_council_destroy($id)
    {
        $heldincouncil = HeldinCouncil::findOrFail($id);
        $heldincouncil->delete();

        return redirect()->route('settings.held_in_council')->with('success', 'Deleted successfully!');
    }

    public function held_in_council_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $heldincouncil = HeldinCouncil::findOrFail($id);
        $heldincouncil->update($validated);

        return redirect()->route('settings.held_in_council')->with('success', 'Updated successfully!');
    }


      
    public function users()
    {
        $users = SystemUser::all();
        return view('AdminDashboard.settings.users', compact('users'));
    }

    public function users_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:system_users,email',
            'contact' => 'required|numeric',
            'password' => 'required|string|max:255|confirmed', 
        ]);
    
        SystemUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'password' => bcrypt($validated['password']), 
        ]);
    
        return redirect()->route('settings.users')->with('success', 'User added successfully!');
    }

    public function users_destroy($id)
    {
        $users = SystemUser::findOrFail($id);
        $users->delete();

        return redirect()->route('settings.users')->with('success', 'User Deleted successfully!');
    }
    
    public function users_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:system_users,email,' . $id,
            'contact' => 'required|numeric',
            'password' => 'nullable|string|max:255|confirmed',
        ]);


        $user = SystemUser::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->contact = $validated['contact'];
        
        if ($request->has('password') && $request->password) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('settings.users')->with('success', 'User updated successfully!');
    }



    public function academic_qualifications()
    {
        $academicqualification = AcademicQualification::all();
        return view('AdminDashboard.settings.aca_quali', compact('academicqualification'));
    }

    public function academic_qualifications_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        AcademicQualification::create($validated);

        return redirect()->route('settings.academic_qualifications')->with('success', 'Academic Qualification added successfully!');
    }


    public function academic_qualifications_destroy($id)
    {
        $academicqualification = AcademicQualification::findOrFail($id);
        $academicqualification->delete();

        return redirect()->route('settings.academic_qualifications')->with('success', 'Academic Qualification deleted successfully!');
    }

    public function academic_qualifications_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $academicqualification = AcademicQualification::findOrFail($id);
        $academicqualification->update($validated);

        return redirect()->route('settings.academic_qualifications')->with('success', 'Academic Qualification updated successfully!');
    }



    public function contribution_types()
    {
        $contribution_types = ContributionType::all();
        return view('AdminDashboard.settings.contribution_types', compact('contribution_types'));
    }

    public function contribution_types_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ContributionType::create($validated);

        return redirect()->route('settings.contribution_types')->with('success', 'Contribution type  added successfully!');
    }


    public function contribution_types_destroy($id)
    {
        $contribution_types = ContributionType::findOrFail($id);
        $contribution_types->delete();

        return redirect()->route('settings.contribution_types')->with('success', 'Contribution type  deleted successfully!');
    }

    public function contribution_types_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $contribution_types = ContributionType::findOrFail($id);
        $contribution_types->update($validated);

        return redirect()->route('settings.contribution_types')->with('success', 'Contribution type updated successfully!');
    }

}
