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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_trace')->constrained('kode_traces   ')->onDelete('cascade');
            $table->foreignId('no_batch')->constrained('cuttings')->onDelete('cascade');
            $table->foreignId('id_ikan')->constrained('kategori_ikans')->onDelete('cascade');
            $table->float('kg');
            $table->integer('pcs');
            $table->date('tgl_service');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
