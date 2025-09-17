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
        Schema::create('cuttingls', function (Blueprint $table) {
            $table->id('cuttingl_id');
            $table->date('tggl_cutting');
            $table->date('tggl_injek_co');
            $table->date('tggl_service');
            $table->unsignedInteger('grade_size_id');
            $table->float('berat_loin');
            $table->float('suhu_loin');
            $table->unsignedBigInteger('penerimaan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuttingls');
    }
};
