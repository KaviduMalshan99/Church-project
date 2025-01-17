<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Member;
use App\Models\Gift; 
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $totalFamilies = Family::count();
        $totalMembers = Member::count();
        $todayTotalFund = Gift::whereDate('created_at', Carbon::today())->sum('amount');
        $methodistMembersCount = Member::where('religion', 'Methodist')->count();

        return view('AdminDashboard.Home', compact('totalFamilies', 'totalMembers', 'todayTotalFund', 'methodistMembersCount'));
    }
}
