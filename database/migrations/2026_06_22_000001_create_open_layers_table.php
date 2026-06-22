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
        // Explicitly target the pgsql connection
        Schema::connection('pgsql')->create('open_layers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layer');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_layer', ['Polygon', 'Point', 'Line']);
            $table->jsonb('geojson'); // jsonb is preferred for postgresql
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql')->dropIfExists('open_layers');
    }
};
