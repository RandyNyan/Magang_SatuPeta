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
            // Nullable column for PostgreSQL open layer reference (no foreign key check because it is cross-database)
            $table->unsignedBigInteger('open_layer_id')->nullable()->after('tipe_layer');
            
            // Make link_openlayer nullable because if it is linked to PostgreSQL open layer, the link will be generated dynamically
            $table->text('link_openlayer')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maps', function (Blueprint $table) {
            $table->dropColumn('open_layer_id');
            $table->text('link_openlayer')->nullable(false)->change();
        });
    }
};
