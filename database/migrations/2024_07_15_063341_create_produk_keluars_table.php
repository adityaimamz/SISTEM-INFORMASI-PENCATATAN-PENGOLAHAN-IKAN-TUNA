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
            $table->integer('p_keluar_id');
            $table->integer('p_masuk_id')->unsigned();
            $table->integer('pcs');
            $table->foreignId('no_container_id');
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
