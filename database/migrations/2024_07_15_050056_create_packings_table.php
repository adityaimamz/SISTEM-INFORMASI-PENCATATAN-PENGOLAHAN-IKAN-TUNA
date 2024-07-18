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
        Schema::create('packings', function (Blueprint $table) {
            $table->string('no_box')->primary(); // Menjadikan no_box sebagai primary key
            $table->string('kode_trace');
            $table->foreign('kode_trace')->references('kode_trace')->on('services')->onDelete('cascade');
            $table->date('tgl_packing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packings');
    }
};
