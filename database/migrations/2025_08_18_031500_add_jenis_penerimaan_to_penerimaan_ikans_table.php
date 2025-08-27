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
            $table->string('jenis_penerimaan', 50)->nullable()->after('supplier_id')->comment('Jenis penerimaan ikan (contoh: Langsung, Titipan, dll)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerimaan_ikans', function (Blueprint $table) {
            $table->dropColumn('jenis_penerimaan');
        });
    }
};
