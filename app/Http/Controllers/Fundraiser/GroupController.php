<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /** READ (daftar) */
    public function index(Request $request)
    {
        $groups = $request->user()->ownedGroups()
            ->withCount(['members' => fn ($q) => $q->where('status', 'active')])
            ->when($request->q, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('fundraiser.groups.index', ['groups' => $groups]);
    }

    /** CREATE (form) */
    public function create()
    {
        return view('fundraiser.groups.create', [
            'categories' => config('galang.group_categories'),
        ]);
    }

    /** CREATE (simpan) */
    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('group-logos', 'public');
        }
        unset($data['logo']);

        $group = $request->user()->ownedGroups()->create($data + ['status' => 'active']);

        return redirect()
            ->route('fundraiser.groups.show', $group)
            ->with('status', 'Grup berhasil dibuat.');
    }

    /** READ (detail) */
    public function show(Group $group)
    {
        Gate::authorize('view', $group);

        $members = $group->members()
            ->where('status', 'active')
            ->with('user')
            ->latest('joined_at')
            ->get();

        $invitation = $group->invitations()->where('is_active', true)->latest()->first();

        return view('fundraiser.groups.show', [
            'group'      => $group,
            'members'    => $members,
            'invitation' => $invitation,
        ]);
    }

    /** UPDATE (form) */
    public function edit(Group $group)
    {
        Gate::authorize('update', $group);

        return view('fundraiser.groups.edit', [
            'group'      => $group,
            'categories' => config('galang.group_categories'),
        ]);
    }

    /** UPDATE (simpan) */
    public function update(Request $request, Group $group)
    {
        Gate::authorize('update', $group);

        $data = $this->validated($request, true);

        if ($request->boolean('remove_logo') && $group->logo_path) {
            Storage::disk('public')->delete($group->logo_path);
            $data['logo_path'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($group->logo_path) {
                Storage::disk('public')->delete($group->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('group-logos', 'public');
        }

        unset($data['logo'], $data['remove_logo']);

        $group->update($data);

        return redirect()
            ->route('fundraiser.groups.show', $group)
            ->with('status', 'Grup berhasil diperbarui.');
    }

    /** DELETE (soft delete) */
    public function destroy(Group $group)
    {
        Gate::authorize('delete', $group);

        $group->delete();

        return redirect()
            ->route('fundraiser.groups.index')
            ->with('status', "Grup {$group->name} berhasil dihapus.");
    }

    private function validated(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'name'        => ['required', 'string', 'max:100'],
            'category'    => ['nullable', Rule::in(config('galang.group_categories'))],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        if ($isUpdate) {
            $rules['status']      = ['required', Rule::in(['active', 'inactive'])];
            $rules['remove_logo'] = ['nullable', 'boolean'];
        }

        return $request->validate($rules, [], [
            'name'        => 'Nama grup',
            'category'    => 'Kategori',
            'description' => 'Deskripsi',
            'logo'        => 'Logo',
            'status'      => 'Status',
        ]);
    }
}
