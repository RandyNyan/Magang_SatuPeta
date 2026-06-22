<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organisasi')->insert([
            [
                'nama' => 'Biro Pemerintahan dan Otonomi Daerah Setda Prov. Jawa Timur',
                'deskripsi' => null,
                'alamat' => 'Jl. Pahlawan No. 110 Alun - Alun Contong, Bubutan, Surabaya',
                'telepon' => '(031) 3524001',
                'email' => 'jks.biroumum@jatimprov.go.id',
                'website' => 'https://www.ro-umum.jatimprov.go.id/',
            ],
            [
                'nama' => 'Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur',
                'deskripsi' => 'Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur',
                'alamat' => 'Jl. Dukuh Menanggal No. 124-126, Surabaya (60234)',
                'telepon' => '031 - 828 0254',
                'email' => 'disnakertrans@jatimprov.go.id',
                'website' => 'https://www.disnakertrans.jatimprov.go.id/',
            ],
            [
                'nama' => 'Badan Penanggulangan Bencana Daerah Provinsi Jawa Timur',
                'deskripsi' => null,
                'alamat' => 'Jl. Letjend. S. Parman No.55, Krajan Kulon, Waru, Kec. Waru, Kabupaten Sidoarjo',
                'telepon' => '(031) 8550222',
                'email' => 'mail@bpbd.jatimprov.go.id',
                'website' => 'https://web.bpbd.jatimprov.go.id/',
            ],
        ]);
    }
}
