<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Menggunakan no_box sebagai primary key
    public $incrementing = false; // Menonaktifkan auto increment
    protected $keyType = 'string'; // Mengatur tipe primary key menjadi string

    public function service()
    {
        return $this->belongsTo(Service::class, 'kode_trace', 'kode_trace');
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
