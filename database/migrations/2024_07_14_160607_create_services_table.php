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
            $table->string('kode_trace')->primary();
            $table->string('no_batch');
            $table->foreign('no_batch')->references('no_batch')->on('cuttings')->onDelete('cascade');
            $table->foreignId('id_detail')->constrained('detail_produks')->onDelete('cascade');
            $table->integer('berat_produk');
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
