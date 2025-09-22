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
            $table->unsignedBigInteger('grade_size_id');
            $table->foreignId('grade_size_id')
                    ->constrained('grade_sizes')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('grade_service_id');
            $table->foreignId('grade_service_id')
                    ->constrained('grade_services')
                    ->onDelete('cascade');
            $table->string('no_batch');
            $table->float('berat_loin');
            $table->float('suhu_loin');
            $table->unsignedBigInteger('penerimaan_id');
            $table->foreignId('penerimaan_id')
                    ->constrained('penerimaan_ikans')
                    ->onDelete('cascade');
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
