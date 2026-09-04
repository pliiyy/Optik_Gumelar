<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'master@gmail.com'],
            [
                'name' => 'Master Admin',
                'password' => Hash::make('admin123'),
                'role' => 'ADMIN',
            ]
        );

        User::updateOrCreate(
            ['email' => 'karyawan@gmail.com'],
            [
                'name' => 'Karyawan Optik',
                'password' => Hash::make('karyawan123'),
                'role' => 'KARYAWAN',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pelanggan@gmail.com'],
            [
                'name' => 'Pelanggan Demo',
                'password' => Hash::make('pelanggan123'),
                'role' => 'PELANGGAN',
            ]
        );
    }
}
