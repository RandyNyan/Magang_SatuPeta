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
        Schema::table('maps', function (Blueprint $table) {
            $table->enum('sumber_peta', ['wms', 'pgsql'])->default('wms')->after('tipe_layer');
            $table->string('pgsql_table')->nullable()->after('sumber_peta');
            $table->text('sld_style')->nullable()->after('pgsql_table');
            $table->json('style_rules')->nullable()->after('sld_style');
            
            // Adjust link_openlayer to be nullable because pgsql maps don't use a hardcoded WMS link
            $table->text('link_openlayer')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maps', function (Blueprint $table) {
            $table->dropColumn(['sumber_peta', 'pgsql_table', 'sld_style', 'style_rules']);
            $table->text('link_openlayer')->nullable(false)->change();
        });
    }
};
