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
            $table->foreignId('kode_trace_id')->constrained('kode_traces')->onDelete('cascade');
            $table->foreignId('no_batch_id')->constrained('no_batches')->onDelete('cascade'); // corrected to use 'cuttings' table
            $table->foreignId('id_ikan')->constrained('Kategori_produks')->onDelete('cascade');
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
