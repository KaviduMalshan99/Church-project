<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalFamilies = Family::count();
        $totalMembers = Member::count();
        return view('AdminDashboard.Home', compact('totalFamilies', 'totalMembers'));
    }
}
