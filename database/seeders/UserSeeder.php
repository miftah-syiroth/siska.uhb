<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleMahasiswa = Role::firstOrCreate(['name' => 'mahasiswa']);
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleDosen = Role::firstOrCreate(['name' => 'dosen']);

        // buat user mahasiswa, admin, dosen dan assign role
        $userMahasiswa = User::firstOrCreate([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@example.com',
        ], [
            'password' => Hash::make('ASDqwe123'),
            'email_verified_at' => now(),
        ]);
        $userMahasiswa->assignRole($roleMahasiswa);

        $userAdmin = User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ], [
            'password' => Hash::make('ASDqwe123'),
            'email_verified_at' => now(),
        ]);
        $userAdmin->assignRole($roleAdmin);

        $userDosen = User::firstOrCreate([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
        ], [
            'password' => Hash::make('ASDqwe123'),
            'email_verified_at' => now(),
        ]);
        $userDosen->assignRole($roleDosen);
    }
}
