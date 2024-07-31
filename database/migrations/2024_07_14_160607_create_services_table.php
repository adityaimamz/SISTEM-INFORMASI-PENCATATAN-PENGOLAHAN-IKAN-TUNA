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
            $table->string('kode_trace')->unique();
            $table->foreignId('no_batch')->constrained('cuttings')->onDelete('cascade');
            $table->foreignId('id_detail')->constrained('detail_produks')->onDelete('cascade');
            $table->float('berat_produk');
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
