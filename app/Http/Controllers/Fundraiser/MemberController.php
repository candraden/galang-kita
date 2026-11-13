<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\GroupMember;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private const STATUSES = ['active', 'exit_pending', 'left', 'removed'];

    /** Daftar anggota dari semua grup milik penggalang dana. */
    public function index(Request $request)
    {
        $groups   = $request->user()->ownedGroups()->orderBy('name')->get(['id', 'name']);
        $groupIds = $groups->pluck('id');

        $status = $request->query('status', 'active');
        if ($status !== 'all' && ! in_array($status, self::STATUSES, true)) {
            $status = 'active';
        }

        $groupId = $request->integer('group') ?: null;
        if ($groupId && ! $groupIds->contains($groupId)) {
            $groupId = null;
        }

        $search = trim((string) $request->query('q', ''));

        // Hitungan per status (ikut filter grup, tidak ikut filter status/pencarian)
        $counts = GroupMember::query()
            ->whereIn('group_id', $groupIds)
            ->when($groupId, fn ($q, $g) => $q->where('group_id', $g))
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $members = GroupMember::query()
            ->whereIn('group_id', $groupIds)
            ->with(['user', 'group'])
            ->when($groupId, fn ($q, $g) => $q->where('group_id', $g))
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($search !== '', fn ($q) => $q->whereHas('user', fn ($u) => $u->where(
                fn ($w) => $w->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")
            )))
            ->orderByDesc('joined_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('fundraiser.members.index', [
            'members' => $members,
            'groups'  => $groups,
            'counts'  => $counts,
            'status'  => $status,
            'groupId' => $groupId,
            'search'  => $search,
        ]);
    }

    /** Keluarkan anggota dari grup. */
    public function remove(Request $request, GroupMember $member)
    {
        $this->authorizeOwner($request, $member);

        if (! in_array($member->status, ['active', 'exit_pending'], true)) {
            return back()->with('error', 'Anggota ini sudah tidak aktif di grup.');
        }

        $member->update(['status' => 'removed', 'left_at' => now()]);

        return back()->with('status', "{$member->user->name} dikeluarkan dari grup {$member->group->name}.");
    }

    /** Pulihkan anggota yang sebelumnya dikeluarkan. */
    public function restore(Request $request, GroupMember $member)
    {
        $this->authorizeOwner($request, $member);

        if ($member->status !== 'removed') {
            return back()->with('error', 'Hanya anggota yang dikeluarkan yang bisa dipulihkan.');
        }

        $member->update(['status' => 'active', 'left_at' => null]);

        return back()->with('status', "{$member->user->name} dipulihkan sebagai anggota grup {$member->group->name}.");
    }

    private function authorizeOwner(Request $request, GroupMember $member): void
    {
        // $member->group bernilai null jika grupnya sudah dihapus (soft delete)
        abort_unless($member->group && $member->group->owner_id === $request->user()->id, 403);
    }
}
