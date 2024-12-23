<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\SubChurch;
use Illuminate\Http\Request;

class ChurchController extends Controller
{
    public function main(Request $request)
    {
        // Fetch paginated churches from the database (e.g., 10 per page)
        $churches = Church::when($request->search, function ($query) use ($request) {
            return $query->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
        })
        ->paginate(10);  // Paginate results

        // Pass the data to the Blade view
        return view('AdminDashboard.church.mainlist', compact('churches'));
    }

    // Store a new church in the database
    public function store(Request $request)
    {
        //dd($request);
        $validated = $request->validate([
            'church_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:15',
        ]);

        Church::create($validated);

        return redirect()->route('church.main')->with('success', 'Church created successfully!');
    }

    // Show the form to edit an existing church
    public function edit($id)
    {
        // Fetch the church by its ID
        $church = Church::findOrFail($id);

        // Pass the data to the edit view
        return view('AdminDashboard.church.edit', compact('church'));
    }

    // Update the existing church data in the database
    public function update(Request $request, $id)
    {
        // Fetch the church by its ID
        $church = Church::findOrFail($id);

        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
        ]);

        // Update the church data
        $church->update($validated);

        // Redirect back with success message
        return redirect()->route('church.main')->with('success', 'Church updated successfully!');
    }

    // Delete the specified church from the database
    public function destroy($id)
    {
        // Fetch the church by its ID
        $church = Church::findOrFail($id);

        // Delete the church
        $church->delete();

        // Redirect back with success message
        return redirect()->route('church.main')->with('success', 'Church deleted successfully!');
    }

    //sub churches
    public function sub(Request $request)
    {
        // Fetch paginated sub-churches and their parent church names
        // Use the correct relationship name 'church' instead of 'parentChurch'
        $subChurches = SubChurch::with('church')->paginate(10);
        
        // Fetch all main churches for the select dropdown
        $churches = Church::all();  
    
        return view('AdminDashboard.church.sublist', compact('subChurches', 'churches'));
    }
    

    public function storeSub(Request $request)
    {
        $validatedData = $request->validate([
            'parent_church_id' => 'required|exists:churches,id',
            'church_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
        ]);

        $subChurch = SubChurch::create($validatedData);

        return redirect()->route('church.sub')->with('success', 'Sub Church created successfully.');
    }

    public function editSub($id)
    {
        $subChurch = SubChurch::findOrFail($id);
        $churches = Church::all();  // Fetch all main churches for the select dropdown

        return view('AdminDashboard.church.editSubChurch', compact('subChurch', 'churches'));
    }

    public function updateSub(Request $request, $id)
    {
        $validatedData = $request->validate([
            'parent_church_id' => 'required|exists:churches,id',
            'church_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
        ]);

        $subChurch = SubChurch::findOrFail($id);
        $subChurch->update($validatedData);

        return redirect()->route('church.sub')->with('success', 'Sub Church updated successfully.');
    }

    public function destroySub($id)
    {
        $subChurch = SubChurch::findOrFail($id);
        $subChurch->delete();

        return redirect()->route('church.sub')->with('success', 'Sub Church deleted successfully.');
    }
}
