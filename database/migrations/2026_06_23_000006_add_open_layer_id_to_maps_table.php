<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maps', function (Blueprint $table) {
            $table->foreignId('open_layer_id')->nullable()->after('sumber_peta')->constrained('open_layers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('maps', function (Blueprint $table) {
            $table->dropForeign(['open_layer_id']);
            $table->dropColumn('open_layer_id');
        });
    }
};
