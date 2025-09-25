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
        Schema::create('penerimaan_ikans', function (Blueprint $table): void {
            $table->bigIncrements('penerimaan_id');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')
                    ->references('supplier_id')
                    ->on('suppliers')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('grade_id');
            $table->foreign('grade_id')
                    ->references('grade_id')
                    ->on('grades')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('kategori_berat_id');
            $table->foreign('kategori_berat_id')
                    ->references('kategori_berat_id')
                    ->on('kategori_berat_penerimaans')
                    ->onDelete('cascade');
            $table->date('tgl_penerimaan');
            $table->date('tgl_bongkar');
            $table->string('jenis_penerimaan');
            $table->string('no_bak')->nullable();
            $table->float('berat_ikan');
            $table->float('suhu_ikan');
            $table->string('no_ikan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerimaan_ikans', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['grade_id']);
            $table->dropForeign(['kategori_berat_id']);
        }); 
        Schema::dropIfExists('penerimaan_ikans');
    }
};
