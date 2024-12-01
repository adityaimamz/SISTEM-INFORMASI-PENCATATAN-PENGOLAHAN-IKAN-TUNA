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
            $table->id();
            $table->string('no_box')->unique(); // Menjadikan no_box sebagai primary key
            $table->foreignId('kode_trace_id')->constrained('services')->onDelete('cascade');
            $table->string('buyer');
            $table->integer('pcs');
            $table->float('berat');
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
