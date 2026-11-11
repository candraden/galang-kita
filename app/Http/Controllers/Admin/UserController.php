<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")))
            ->when($request->role, fn ($q, $r) => $q->whereHas('roles', fn ($w) => $w->where('name', $r)))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', ['users' => $users]);
    }

    public function toggle(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Anda tidak dapat menangguhkan akun sendiri.');
        }

        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Akun Super Admin tidak dapat ditangguhkan.');
        }

        $user->status = $user->status === 'suspended' ? 'active' : 'suspended';
        $user->save();

        return back()->with('status', $user->status === 'suspended'
            ? "Akun {$user->name} ditangguhkan."
            : "Akun {$user->name} diaktifkan kembali.");
    }
}
