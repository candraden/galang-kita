<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return match ($request->user()->currentRole()) {
            'super_admin' => redirect()->route('admin.dashboard'),
            'fundraiser'  => redirect()->route('fundraiser.dashboard'),
            'member'      => redirect()->route('member.dashboard'),
            default       => abort(403, 'Akun Anda belum memiliki peran.'),
        };
    }
}
