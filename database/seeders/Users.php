<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => Str::uuid(),
                'name' => 'SuperAdmin User',
                'username' => 'superadmin',
                'email' => 'superadmin@mail.com',
                'password' => Hash::make('superadmin'),
                'role' => UserRole::SuperAdmin->value,
                'profile_photo_path' => '/assets/img/profile/admin.png',
                'created_at' => now(),
                'email_verified_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin'),
                'role' => UserRole::Admin->value,
                'profile_photo_path' => '/assets/img/profile/admin.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Regular User',
                'username' => 'user',
                'email' => 'user@mail.com',
                'password' => Hash::make('user'),
                'role' => UserRole::User->value,
                'profile_photo_path' => '/assets/img/profile/user.png',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
