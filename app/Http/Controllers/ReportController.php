<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Member;
use App\Models\Family;
use App\Models\Gift;
use App\Models\ContributionType;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function families()
    {
        $families = Family::with('mainPerson')->get();
        $totalFamilies = Family::count();
        return view('AdminDashboard.Reports.family_report', compact('families','totalFamilies'));
    }


   public function members(Request $request)
    {
        $query = Member::query();

        // Filter by Full Members
        if ($request->full_members_filter === 'yes') {
            $query->where('full_member', 1);
        } elseif ($request->full_members_filter === 'no') {
            $query->where('full_member', 0);
        }

         // Filter by Baptized Members
         if ($request->baptized === 'yes') {
            $query->where('baptized', 1);
        } elseif ($request->baptized === 'no') {
            $query->where('baptized', 0);
        }

        // Filter by age of Baptized Members
        if ($request->baptized_filter === 'baptised_less_5') {
            $query->where('baptized', 1)
                ->where('birth_date', '>=', now()->subYears(5));
        } elseif ($request->baptized_filter === 'baptised_5_to_15') {
            $query->where('baptized', 1)
                ->whereBetween('birth_date', [now()->subYears(15), now()->subYears(5)]);
        } elseif ($request->baptized_filter === 'baptised_over_15') {
            $query->where('baptized', 1)
                ->where('birth_date', '<=', now()->subYears(15));
        }

            // Filter by age
            if ($request->filled('age_range')) {
            $ageRange = $request->age_range;
            if ($ageRange == '0-18') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 0 AND 18');
            } elseif ($ageRange == '19-25') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 19 AND 25');
            } elseif ($ageRange == '26-35') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 26 AND 35');
            } elseif ($ageRange == '36-50') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 36 AND 50');
            } elseif ($ageRange == '51+') {
                $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= 51');
            }
        }

         // Filter by number of members baptized during a period
        if ($request->filled('baptized_start') && $request->filled('baptized_end')) {
            $query->whereBetween('baptized_date', [$request->baptized_start, $request->baptized_end]);
        }

        // Filter by number of marriages during a period
        if ($request->filled('marriage_start') && $request->filled('marriage_end')) {
            $query->whereBetween('married_date', [$request->marriage_start, $request->marriage_end]);
        }

         // Filter by number of marriages during a period
         if ($request->filled('death_start') && $request->filled('death_end')) {
            $query->whereBetween('date_of_death', [$request->death_start, $request->death_end]);
        }

        // Filter by number of members accepted as full members during a year
        if ($request->filled('full_member_year')) {
            $query->whereYear('full_member_date', $request->full_member_year);
        }

        // Fetch the filtered members
        $members = $query->get();

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




    public function areaWiseReport(Request $request)
{
    $area = $request->input('area');
    
    $data = DB::table('members')
        ->select('area', 'family_no', 'member_name','contact_info')
        ->when($area, function ($query, $area) {
            return $query->where('area', $area);
        })
        ->orderBy('family_no')
        ->paginate(10);  // Paginate with 10 records per page

    // Get all unique areas
    $areas = DB::table('members')->select('area')->distinct()->pluck('area');
    
    return view('AdminDashboard.Reports.area_wise_report', compact('data', 'area', 'areas'));
}

    public function downloadAreaReportPDF(Request $request)
    {
        $area = $request->input('area');
    
        $data = DB::table('members')
            ->select('area', 'family_no', 'member_name','contact_info')
            ->when($area, function ($query, $area) {
                return $query->where('area', $area);
            })
            ->orderBy('family_no')
            ->get();
    
        $safeArea = preg_replace('/[^A-Za-z0-9 _-]/', '_', $area);
        $filename = 'Area_Report_' . $safeArea . '.pdf';
    
        $pdf = Pdf::loadView('AdminDashboard.Reports.area_report_pdf', compact('data', 'area'));
        return $pdf->download($filename);
    }

    
}
