<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemUser;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    

    public function show()
    {
        $admin = SystemUser::where('email', session('email'))->first(); 
        if (!$admin) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Admin not found.']);
        }
        return view('AdminDashboard.profile', compact('admin'));
    }
    
    

    public function update(Request $request)
    {
        $admin = SystemUser::where('email', session('email'))->first();
    
        if (!$admin) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Admin not found.']);
        }
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:15',
            'current_password' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Verify current password
        if (!\Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    
        // Update admin details
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->contact = $request->contact;
    
        // Update password if provided
        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }
    
        // Update signature if uploaded
        if ($request->hasFile('signature')) {
            if ($admin->signature && \Storage::disk('public')->exists($admin->signature)) {
                \Storage::disk('public')->delete($admin->signature);
            }
    
            $file = $request->file('signature');
            $admin->signature = $file->storeAs('signatures', $file->getClientOriginalName(), 'public');
        }
    
        $admin->save();
    
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
    




}
