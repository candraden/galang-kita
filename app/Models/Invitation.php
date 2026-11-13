<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Invitation extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_active'  => 'boolean',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function generateToken(): string
    {
        do {
            $token = Str::random(32);
        } while (static::where('token', $token)->exists());

        return $token;
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isFull(): bool
    {
        return $this->max_uses !== null && $this->used_count >= $this->max_uses;
    }

    /** Alasan tautan tidak bisa dipakai, atau null jika masih valid. */
    public function unusableReason(): ?string
    {
        if (! $this->is_active) {
            return 'Tautan undangan ini sudah dinonaktifkan.';
        }
        if ($this->isExpired()) {
            return 'Tautan undangan ini sudah kedaluwarsa.';
        }
        if ($this->isFull()) {
            return 'Tautan undangan ini sudah mencapai batas penggunaan.';
        }
        if (! $this->group || $this->group->status !== 'active') {
            return 'Grup ini sedang tidak aktif.';
        }

        return null;
    }

    public function isUsable(): bool
    {
        return $this->unusableReason() === null;
    }

    /**
     * Masukkan user ke grup lewat tautan ini.
     * used_count hanya bertambah bila user benar-benar bergabung (bukan yang sudah anggota).
     */
    public function redeem(User $user): GroupMember
    {
        return DB::transaction(function () use ($user) {
            $invitation = static::whereKey($this->id)->lockForUpdate()->first();
            $invitation->load('group');

            if ($reason = $invitation->unusableReason()) {
                throw ValidationException::withMessages(['invitation' => $reason]);
            }

            $group = $invitation->group;

            if ($group->owner_id === $user->id) {
                throw ValidationException::withMessages(['invitation' => 'Kamu adalah pemilik grup ini.']);
            }

            $member = GroupMember::where('group_id', $group->id)
                ->where('user_id', $user->id)
                ->first();

            if ($member && in_array($member->status, ['active', 'exit_pending'], true)) {
                return $member; // sudah anggota
            }

            if ($member && $member->status === 'removed') {
                throw ValidationException::withMessages([
                    'invitation' => 'Kamu tidak dapat bergabung kembali ke grup ini. Hubungi penggalang dana.',
                ]);
            }

            if ($member) { // pernah keluar -> aktifkan lagi
                $member->update([
                    'status'        => 'active',
                    'joined_at'     => now(),
                    'left_at'       => null,
                    'invitation_id' => $invitation->id,
                ]);
            } else {
                $member = GroupMember::create([
                    'group_id'      => $group->id,
                    'user_id'       => $user->id,
                    'invitation_id' => $invitation->id,
                    'status'        => 'active',
                    'joined_at'     => now(),
                ]);
            }

            $invitation->increment('used_count');

            return $member;
        });
    }
}
