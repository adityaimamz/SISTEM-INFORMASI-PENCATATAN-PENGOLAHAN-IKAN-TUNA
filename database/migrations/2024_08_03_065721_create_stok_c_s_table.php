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
        Schema::create('stok_c_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_trace_id')->constrained('services')->onDelete('cascade');
            $table->string('tipe_stok');
            $table->integer('pcs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_c_s');
    }
};
