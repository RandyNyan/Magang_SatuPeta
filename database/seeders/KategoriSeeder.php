<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Batas Wilayah', 'Kependudukan', 'Lingkungan Hidup',
            'Pemerintah & Desa', 'Pendidikan', 'Sosial',
            'Pendidikan SD', 'Pariwisata & Kebudayaan', 'Kesehatan',
            'Ekonomi', 'Kemiskinan', 'Infrastruktur'
        ];

        foreach ($kategoris as $kategori) {
            DB::table('kategori')->insert([
                'nama_kategori' => $kategori,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
