<?php

namespace App\Http\Controllers;
use App\Models\Occupation;
use App\Models\Religion;
use Illuminate\Http\Request;

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


}
