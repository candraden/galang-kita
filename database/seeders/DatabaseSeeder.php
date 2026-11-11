<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roles = collect(['super_admin', 'fundraiser', 'member'])
            ->mapWithKeys(fn ($name) => [$name => Role::firstOrCreate(['name' => $name])]);

        $make = function (string $name, string $email, string $role) use ($roles) {
    $user = User::unguarded(fn () => User::firstOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]
    ));
    $user->roles()->syncWithoutDetaching([$roles[$role]->id]);

    return $user;
};
            

        $make('Super Admin', 'admin@galangkita.test', 'super_admin');
        $fundraiser = $make('Budi Santoso', 'budi@galangkita.test', 'fundraiser');
        $member1    = $make('Rian Pratama', 'rian@galangkita.test', 'member');
        $member2    = $make('Siti Aminah', 'siti@galangkita.test', 'member');

        $groups = [
            ['Paguyuban Warga Harmoni', 'Kas dan iuran warga', 'Komunitas'],
            ['Panitia Dies Natalis', 'Dana kegiatan kampus', 'Kepanitiaan'],
        ];

        foreach ($groups as [$name, $desc, $category]) {
            $group = Group::firstOrCreate(
                ['name' => $name, 'owner_id' => $fundraiser->id],
                ['description' => $desc, 'category' => $category, 'status' => 'active']
            );

            foreach ([$member1, $member2] as $member) {
                GroupMember::firstOrCreate(
                    ['group_id' => $group->id, 'user_id' => $member->id],
                    ['status' => 'active', 'joined_at' => now()]
                );
            }
        }
    }
}