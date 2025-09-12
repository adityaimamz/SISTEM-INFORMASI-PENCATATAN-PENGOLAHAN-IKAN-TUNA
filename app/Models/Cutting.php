<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutting extends Model
{
    use HasFactory;

    protected $table = 'cuttings';
    protected $primaryKey = 'cutting_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'tgl_cutting',
        'tgl_injek_co',
        'penerimaan_id',
        'kategori_byproduk_id',
        'no_batch',
        'berat_produk',
        'total_produk',
    ];

    protected $casts = [
        'tgl_cutting' => 'date:Y-m-d',
        'tgl_injek_co' => 'date:Y-m-d',
        'berat_produk' => 'json',
        'total_produk' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Pastikan data yang disimpan valid
            if (is_array($model->berat_produk)) {
                $model->berat_produk = array_map('floatval', $model->berat_produk);
            }
            if (is_array($model->total_produk)) {
                $model->total_produk = array_map('intval', $model->total_produk);
            }
        });
    }

    public function penerimaan_ikans()
    {
        return $this->belongsTo(Penerimaan_ikans::class, 'penerimaan_id', 'penerimaan_id');
    }
    
    public function kategori_byproduk()
    {
        return $this->belongsTo(KategoriByprodukCt::class, 'kategori_byproduk_id', 'kategori_byproduk_id');
    }
    
    public function services()
    {
        return $this->hasMany(Service::class, 'cutting_id');
    }
}
