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
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->foreignId('kategori_berat_id')->constrained('kategori_berat_penerimaans')->onDelete('cascade');
            $table->float('berat_ikan');
            $table->date('tgl_penerimaan');
            $table->date('tgl_bongkar');
            $table->float('suhu_ikan');
            $table->string('no_bak')->nullable();
            $table->string('no_ikan');
            $table->timestamps();

            $table->foreign('supplier_id')
                  ->references('supplier_id')
                  ->on('suppliers')
                  ->onDelete('cascade');
        });

        Schema::table('penerimaan_ikans', function (Blueprint $table): void {
            $table->string('jenis_penerimaan', 50)->nullable()->after('supplier_id')->comment('Fresh GG atau Frozen WR');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerimaan_ikans', function (Blueprint $table): void {
            $table->dropColumn('jenis_penerimaan');
        });
        
        Schema::dropIfExists('penerimaan_ikans');
    }
};
