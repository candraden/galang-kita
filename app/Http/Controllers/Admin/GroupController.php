<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::with('owner')
            ->withCount('members')
            ->when($request->q, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.groups', ['groups' => $groups]);
    }

    public function toggle(Group $group)
    {
        $group->status = $group->status === 'active' ? 'inactive' : 'active';
        $group->save();

        return back()->with('status', $group->status === 'active'
            ? "Grup {$group->name} diaktifkan."
            : "Grup {$group->name} dinonaktifkan.");
    }
}
