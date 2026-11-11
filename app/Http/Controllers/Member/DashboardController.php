<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $memberships = $request->user()->memberships()
            ->where('status', 'active')
            ->with('group.owner')
            ->latest('joined_at')
            ->get();

        return view('member.dashboard', ['memberships' => $memberships]);
    }
}
