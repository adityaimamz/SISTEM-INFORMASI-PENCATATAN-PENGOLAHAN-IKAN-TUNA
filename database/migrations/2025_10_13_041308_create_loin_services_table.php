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
        Schema::create('loin_services', function (Blueprint $table) {
            $table->bigIncrements('loin_service_id');
            $table->date('tgl_service');

            // Pastikan tipe data sama dengan tabel yang direferensi
            $table->unsignedBigInteger('penerimaan_id')->nullable();
            $table->unsignedBigInteger('cuttingl_id')->nullable();
            $table->unsignedBigInteger('kategori_produk_id')->nullable();

            $table->string('kode_lot')->nullable();
            $table->float('berat_loin')->default(0)->nullable();
            $table->float('pcs_loin')->default(0)->nullable();
            $table->timestamps();
        });

        Schema::table('loin_services', function (Blueprint $table) {
            $table->foreign('penerimaan_id')
                  ->references('penerimaan_id')
                  ->on('penerimaan_ikans')
                  ->onDelete('cascade');

            $table->foreign('cuttingl_id')
                  ->references('cuttingl_id')
                  ->on('cuttingls')
                  ->onDelete('cascade');

            $table->foreign('kategori_produk_id')
                  ->references('kategori_produk_id')
                  ->on('kategori_produks')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loin_services');
    }
};
