<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers'   => User::count(),
            'newUsers'     => User::where('created_at', '>=', now()->subDays(7))->count(),
            'totalGroups'  => Group::count(),
            'activeGroups' => Group::where('status', 'active')->count(),
            'latestUsers'  => User::with('roles')->latest()->take(5)->get(),
        ]);
    }
}
