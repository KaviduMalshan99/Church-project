<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SystemUser; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('AdminDashboard.admin_login'); 
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        $hardcodedAdminEmail = 'admin@example.com';
        $hardcodedAdminPassword = '12345678'; 
    
        $admin = \App\Models\SystemUser::where('email', $request->email)
            ->first();
    
        if ($admin && password_verify($request->password, $admin->password)) {
            session([
                'is_admin' => true, 
                'name' => $admin->name, 
                'email' => $admin->email,
            ]);
            return redirect()->route('dashboard');
        }
    
        if ($request->email === $hardcodedAdminEmail && $request->password === $hardcodedAdminPassword) {
            session([
                'is_admin' => true, 
                'name' => 'Admin', 
                'email' => $hardcodedAdminEmail,
            ]);

            session()->flash('success', 'Successfully logged in as Admin.');
            return redirect()->route('dashboard'); 
        }
    
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }
    




    public function logout(Request $request)
    {

        $request->session()->flush();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }


}
