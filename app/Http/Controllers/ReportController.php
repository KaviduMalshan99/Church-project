<?php

namespace App\Http\Controllers;
use App\Models\Member;
use App\Models\Family;
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
}
