<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /** Halaman publik tautan undangan. */
    public function show(Request $request, string $token)
    {
        $invitation = Invitation::with('group.owner')->where('token', $token)->firstOrFail();
        $group = $invitation->group;

        // Setelah login, kembalikan user ke halaman ini
        if (! $request->user()) {
            session(['url.intended' => route('invitations.show', $token)]);
        }

        return view('invitations.show', [
            'invitation'  => $invitation,
            'group'       => $group,
            'reason'      => $invitation->unusableReason(),
            'memberCount' => $group ? $group->members()->where('status', 'active')->count() : 0,
        ]);
    }

    /** Anggota yang sudah login menekan "Gabung". */
    public function join(Request $request, string $token)
    {
        $invitation = Invitation::with('group')->where('token', $token)->firstOrFail();
        $user = $request->user();

        if (! $user->hasRole('member')) {
            return back()->with('error', 'Akun ini terdaftar sebagai Penggalang Dana. Untuk bergabung sebagai anggota, daftar dengan akun lain melalui tautan ini.');
        }

        $already = $invitation->group
            && GroupMember::where('group_id', $invitation->group_id)
                ->where('user_id', $user->id)
                ->whereIn('status', ['active', 'exit_pending'])
                ->exists();

        $invitation->redeem($user); // gagal -> ValidationException, kembali ke halaman dengan pesan

        return redirect()->route('member.dashboard')->with('status', $already
            ? 'Kamu sudah menjadi anggota grup '.$invitation->group->name.'.'
            : 'Berhasil bergabung ke grup '.$invitation->group->name.'.');
    }
}
