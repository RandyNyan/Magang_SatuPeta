<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->id();

            $table->string('judul_mapset');
            $table->text('deskripsi');
            $table->string('skala');
            $table->enum('sistem_proyeksi', ['UTM', 'WGS 84']);
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('organisasi_id')->constrained('organisasi')->onDelete('cascade');
            $table->enum('tipe_layer', ['Polygon', 'Point', 'Line']);

            $table->text('link_openlayer'); // Menggunakan text untuk berjaga-jaga jika URL-nya sangat panjang
            $table->enum('tingkat_penyajian', ['Desa/Kelurahan', 'Kecamatan', 'Kabupaten/Kota', 'Provinsi']);
            $table->enum('cakupan_wilayah', ['Desa/Kelurahan', 'Kecamatan', 'Kabupaten/Kota', 'Provinsi']);
            $table->year('tahun_data'); // Tipe data khusus tahun

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maps');
    }
};
