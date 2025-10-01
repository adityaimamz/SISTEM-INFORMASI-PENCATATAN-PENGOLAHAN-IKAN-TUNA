<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *Run the migrations*
     **/
    public function up(): void
    {
        Schema::create('cuttingls', function (Blueprint $table) {
            $table->bigIncrements('cuttingl_id');
            $table->date('tggl_cutting');
            $table->date('tggl_injek_co');
            $table->date('tggl_service');

            // Pastikan tipe data sama dengan tabel yang direferensi
            $table->unsignedBigInteger('grade_size_id');
            $table->unsignedBigInteger('grade_service_id');
            $table->unsignedBigInteger('penerimaan_id');

            $table->string('no_batch');
            $table->float('berat_loin');
            $table->float('suhu_loin');
            $table->float('pcs_loin');
            $table->float('berat_rm');
            $table->float('pcs_rm');
            $table->float('berat_hs');
            $table->float('pcs_hs');

            $table->timestamps();
        });

        // Tambahkan foreign key constraints setelah semua tabel dibuat
        Schema::table('cuttingls', function (Blueprint $table) {
            // Pastikan urutan penambahan foreign key sesuai dengan urutan pembuatan tabel
            $table->foreign('grade_size_id')
                  ->references('grade_size_id')
                  ->on('grade_sizings')
                  ->onDelete('cascade');

            $table->foreign('grade_service_id')
                  ->references('grade_service_id')
                  ->on('grade_services')
                  ->onDelete('cascade');

            $table->foreign('penerimaan_id')
                  ->references('penerimaan_id')
                  ->on('penerimaan_ikans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuttingls', function (Blueprint $table) {
            $table->dropForeign(['grade_size_id']);
            $table->dropForeign(['grade_service_id']);
            $table->dropForeign(['penerimaan_id']);
        });
        
        Schema::dropIfExists('cuttingls');
    }
};
