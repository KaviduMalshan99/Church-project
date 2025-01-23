<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        $groupsCount = Group::all()->count();
        // dd($groupsCount);
        return view('adminDashboard.group.group_list', compact('groups', 'groupsCount'));
    }

    public function create()
    {
        $members = Member::all();
        return view('adminDashboard.group.add_group', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:255|unique:groups,group_name',
            'member_id' => 'required|array',
            'member_id.*' => 'exists:members,member_id',
        ]);

        // dd(json_encode($request->member_id, JSON_UNESCAPED_SLASHES));

        $group = Group::create([
            'group_name' => $request->group_name,
            'group_members' => json_encode($request->member_id, JSON_UNESCAPED_SLASHES), // Convert array to JSON
        ]);


        return redirect()->route('group.list')->with('success', 'Group created successfully!');
    }


    public function edit($id)
    {
        $group = Group::findorFail($id);
        $members = Member::all();
        return view('AdminDashboard.group.edit_group', compact('group', 'members'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'group_name' => 'required|string|max:255|unique:groups,group_name',
            'member_id' => 'required|array',
            'member_id.*' => 'exists:members,member_id',
        ]);

        // dd(json_encode($request->member_id, JSON_UNESCAPED_SLASHES));
        $group = Group::findorFail($id);
        $group->update([
            'group_name' => $request->group_name,
            'group_members' => json_encode($request->member_id, JSON_UNESCAPED_SLASHES), // Convert array to JSON
        ]);


        return redirect()->route('group.list')->with('success', 'Group updated successfully!');
    }

    public function destroy($id)
    {
        // Fetch the church by its ID
        $group = Group::findOrFail($id);

        $group->delete();
        // Redirect back with success message
        return redirect()->route('group.list')->with('success', __('Family deleted successfully!'));
    }

    public function send_message(Request $request, $id)
    {
        // dd('test');
        $group = Group::findorFail($id);
        $group_members = json_decode($group->group_members);
        foreach ($group_members as $member) {
            // dd($member);
            $member = Member::where("member_id", $member)->first();
            $response = Http::post('https://app.notify.lk/api/v1/send', [
                'user_id'   => config('services.notify.user_id'),
                'api_key'   => config('services.notify.api_key'),
                'sender_id' => 'NotifyDEMO',
                'to'        => $member->contact_info,
                'message'   => $request->message,
            ]);
            
        }        
        return redirect()->route('group.list')->with('success', 'Message send successfully!');
    }
}
