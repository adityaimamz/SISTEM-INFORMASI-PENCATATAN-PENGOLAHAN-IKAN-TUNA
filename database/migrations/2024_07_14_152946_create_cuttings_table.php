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
            $table->id(); 
            $table->foreignId('no_batch_id')->constrained('no_batches')->onDelete('cascade'); // corrected to use 'no_batches' table
            $table->foreignId('id_produk')->constrained('penerimaan_ikans')->onDelete('cascade');
            $table->foreignId('kategori_berat_id')->constrained('kategori_berat_cuttings')->onDelete('cascade');
            $table->float('berat_produk');
            $table->date('tgl_cutting');
            $table->timestamps();
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
