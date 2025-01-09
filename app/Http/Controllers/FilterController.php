<?php

namespace App\Http\Controllers;
use App\Models\Family;
use App\Models\Member;
use App\Models\Religion;
use App\Models\Occupation;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        // Filter by member name or ID
        if ($request->filled('member')) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('member_name', 'LIKE', '%' . $request->member . '%')
                        ->orWhere('member_id', $request->member);
            });
        }

        // Filter by family number
        if ($request->filled('family_no')) {
            $query->where('family_no', $request->family_no);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
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
        

        // Filter by civil status
        if ($request->filled('civil_status')) {
            $query->where('civil_status', $request->civil_status);
        }

        // Filter by church congregation
        if ($request->filled('church_congregation')) {
            $query->where('church_congregation', $request->church_congregation);
        }

        // Filter by religion
        if ($request->filled('religion')) {
            $query->where('religion', $request->religion);
        }

        // Filter by occupation
        if ($request->filled('occupation')) {
            $query->where('occupation', $request->occupation);
        }

        // Filter by baptized status
        if ($request->filled('baptized')) {
            $query->where('baptized', $request->baptized);
        }

        $members = $query->paginate(10); 

        // Fetch options for dropdowns
        $familyNumbers = Member::distinct('family_no')->pluck('family_no');
        $memberIds = Member::distinct('member_id')->pluck('member_id');
        $religions = Religion::all();
        $occupations = Occupation::all();

        return view('AdminDashboard.filter.index', compact('members', 'familyNumbers', 'memberIds', 'religions', 'occupations'));
    }

    public function show($id)
    {
        $decodedId = urldecode($id);
        $member = Member::where('id', $decodedId)->first();
    
        if (!$member) {
            return redirect()->route('filter.index')->with('error', 'Member not found.');
        }
    
        return view('AdminDashboard.filter.member_details', compact('member'));
    }
    

 
}
