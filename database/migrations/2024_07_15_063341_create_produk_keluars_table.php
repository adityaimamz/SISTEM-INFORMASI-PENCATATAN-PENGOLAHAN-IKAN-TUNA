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
        Schema::create('produk_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_trace_id')->constrained('services')->onDelete('cascade');
            $table->integer('pcs');
            $table->integer('no_seal');
            $table->integer('no_container');
            $table->date('tgl_keluar');
            $table->date('tgl_berangkat');
            $table->date('tgl_tiba');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_keluars');
    }
};
