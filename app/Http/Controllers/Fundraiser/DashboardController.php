<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $groups = $request->user()->ownedGroups()
            ->withCount(['members' => fn ($q) => $q->where('status', 'active')])
            ->latest()
            ->get();

        return view('fundraiser.dashboard', [
            'groups'       => $groups,
            'totalMembers' => $groups->sum('members_count'),
        ]);
    }
}
