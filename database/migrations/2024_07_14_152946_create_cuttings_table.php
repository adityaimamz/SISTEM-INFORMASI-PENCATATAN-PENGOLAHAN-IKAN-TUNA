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
        Schema::create('cuttings', function (Blueprint $table) {
            $table->unsignedInteger('cuttings_id')->primary();
            $table->date('tgl_cutting');
            $table->date('tgl_injek_co');
            $table->unsignedBigInteger ('penerimaan_id')->unsigned();
            $table->unsignedBigInteger ('produk_id')->unsigned();
            $table->char('no_batch');
            $table->float('berat_produk');
            $table->float('total_produk');
            $table->timestamps();

            $table->foreign('penerimaan_id')
                  ->references('penerimaan_id')
                  ->on('penerimaan_ikans')
                  ->onDelete('cascade');

            $table->foreign('ketegori_byproduk_id')
                  ->references('ketegori_byproduk_id')
                  ->on('kategori_byproduk_cts')
                  ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuttings');
    }
};
