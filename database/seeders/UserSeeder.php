<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data role
        $adminRole = Role::where('slug', 'admin')->first();
        $instructorRole = Role::where('slug', 'instructor')->first();

        // Pastikan role admin ditemukan sebelum membuat user
        if ($adminRole) {
            User::updateOrCreate(
                ['email' => 'admin@learnify.test'], // Cek berdasarkan email
                [
                    'role_id'  => $adminRole->id,
                    'name'     => 'Admin Learnify',
                    'password' => Hash::make('password'), // Wajib di-hash
                    'email_verified_at' => now(),
                ]
            );
        }

        // Pastikan role instructor ditemukan sebelum membuat user
        if ($instructorRole) {
            User::updateOrCreate(
                ['email' => 'instructor@learnify.test'], // Cek berdasarkan email
                [
                    'role_id'  => $instructorRole->id,
                    'name'     => 'Instructor Learnify',
                    'password' => Hash::make('password'), // Wajib di-hash
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}