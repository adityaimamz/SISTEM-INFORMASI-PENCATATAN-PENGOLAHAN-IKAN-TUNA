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
        Schema::create('penerimaan_ikans', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_id');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->foreignId('kategori_berat_id')->constrained('kategori_berat_penerimaans')->onDelete('cascade');
            $table->float('berat_ikan');
            $table->string('tgl_penerimaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_ikans');
    }
};
