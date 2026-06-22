<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'Data Geospatial Walidata',
                'username' => 'walidata',
                'email' => 'email123@example.com',
                'password' => Hash::make('password123'),
                'nip' => '0123456789',
                'jabatan' => 'Walidata',
                'role' => 'Walidata',
                'organisasi_id' => 1,
                'foto_profil' => null,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Walidata Demo',
                'username' => 'walidata_demo',
                'email' => 'walidata@jatimprov.go.id',
                'password' => Hash::make('walidatademo123'),
                'nip' => '123',
                'jabatan' => 'Walidata',
                'role' => 'Walidata',
                'organisasi_id' => 2,
                'foto_profil' => null,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
