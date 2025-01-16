<?php

namespace App\Http\Controllers;
use App\Models\Member;
use App\Models\Family;
use App\Models\Gift;
use App\Models\ContributionType;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function families()
    {
        $families = Family::with('mainPerson')->get();
        return view('AdminDashboard.Reports.family_report', compact('families'));
    }

    public function members()
    {
        $members = Member::all();
        return view('AdminDashboard.Reports.member_report', compact('members'));
    }

    public function fund_list(Request $request)
    {
        $contribution_types = ContributionType::all();
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $contribution_type = $request->input('contribution_type');  // Use contribution_type instead of type

        $gifts = Gift::with('member')
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($contribution_type && $contribution_type != 'all', function ($query) use ($contribution_type) {
                return $query->where('type', $contribution_type);  // Filter by contribution_type
            })
            ->get();

        $totalAmount = $gifts->sum('amount');

        return view('AdminDashboard.Reports.fund_report', compact('gifts', 'totalAmount', 'contribution_types'));
    }

    

    
}
