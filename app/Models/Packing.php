<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'kode_lot');
    }

    public function produk_masuk()
    {
        return $this->hasMany(ProdukMasuk::class, 'no_box');
    }

    public function produk_keluar()
    {
        return $this->hasMany(ProdukKeluar::class, 'no_box');
    }
}
