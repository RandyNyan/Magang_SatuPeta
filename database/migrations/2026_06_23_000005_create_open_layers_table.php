<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('open_layers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layer');
            $table->text('deskripsi')->nullable();
            $table->string('pgsql_table');
            $table->string('geom_column')->default('geom');
            $table->string('style_column')->nullable();
            $table->text('sld_style')->nullable();
            $table->json('style_rules')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('open_layers');
    }
};
