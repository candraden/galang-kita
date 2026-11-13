<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class InvitationController extends Controller
{
    /** Buat tautan baru; tautan aktif sebelumnya otomatis dinonaktifkan. */
    public function store(Request $request, Group $group)
    {
        Gate::authorize('update', $group);

        $data = $request->validate([
            'expires_in' => ['nullable', Rule::in(['1', '7', '30'])],
            'max_uses'   => ['nullable', 'integer', 'min:1', 'max:10000'],
        ], [], [
            'expires_in' => 'Masa berlaku',
            'max_uses'   => 'Batas penggunaan',
        ]);

        DB::transaction(function () use ($request, $group, $data) {
            $group->invitations()->where('is_active', true)->update(['is_active' => false]);

            $group->invitations()->create([
                'created_by' => $request->user()->id,
                'token'      => Invitation::generateToken(),
                'expires_at' => ! empty($data['expires_in']) ? now()->addDays((int) $data['expires_in']) : null,
                'max_uses'   => $data['max_uses'] ?? null,
                'is_active'  => true,
            ]);
        });

        return redirect()
            ->route('fundraiser.groups.show', $group)
            ->with('status', 'Tautan undangan baru berhasil dibuat.');
    }

    public function deactivate(Group $group, Invitation $invitation)
    {
        Gate::authorize('update', $group);
        abort_unless($invitation->group_id === $group->id, 404);

        $invitation->update(['is_active' => false]);

        return redirect()
            ->route('fundraiser.groups.show', $group)
            ->with('status', 'Tautan undangan dinonaktifkan.');
    }
}
