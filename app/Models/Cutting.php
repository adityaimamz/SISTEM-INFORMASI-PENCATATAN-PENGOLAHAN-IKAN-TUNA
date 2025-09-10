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
        'berat_produk',
        'total_produk',
    ];

    protected $casts = [
        'berat_produk' => 'array',
        'total_produk' => 'array',
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
