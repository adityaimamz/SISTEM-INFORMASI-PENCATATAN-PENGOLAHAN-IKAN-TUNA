<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutting extends Model
{
    use HasFactory;

    protected $table  = 'cuttings';
    protected $primaryKey = 'cutting_id';
    public $incrementing = false;


    protected $fillable = [
        'cutting_id',
        'tgl_cutting',
        'tgl_injek_co',
        'penerimaan_id',
        'kategori_byproduk_id',
        'no_batch',
        'berat_produk1',
        'total_produk1',
        'berat_produk2',
        'total_produk2',
        'berat_produk3',
        'total_produk3',
        'berat_produk4',
        'total_produk4',
        'berat_produk5',
        'total_produk5',
        'berat_produk6',
        'total_produk6',
        'berat_produk7',
        'total_produk7',
    ];

    protected $dates = [
        'tgl_cutting',
        'tgl_injek_co',
    ];

    public function penerimaan_ikan()
    {
        return $this->belongsTo(Penerimaan_ikan::class, 'penerimaan_id', 'penerimaan_id');
    }
    
    public function services()
    {
        return $this->hasMany(Service::class, 'cutting_id');
    }
    
    public function kategori_byproduk_id()
    {
        return $this->belongsTo(KategoriByprodukCt::class, 'kategori_byproduk_id', 'kategori_byproduk_id');
    }
}
