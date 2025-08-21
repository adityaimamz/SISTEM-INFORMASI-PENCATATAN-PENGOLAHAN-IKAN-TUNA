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
        Schema::table('penerimaan_ikans', function (Blueprint $table) {
            $table->decimal('suhu_ikan', 5, 2)->nullable()->after('berat_ikan')->comment('Suhu ikan dalam derajat Celsius');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerimaan_ikans', function (Blueprint $table) {
            $table->dropColumn('suhu_ikan');
        });
    }
};
