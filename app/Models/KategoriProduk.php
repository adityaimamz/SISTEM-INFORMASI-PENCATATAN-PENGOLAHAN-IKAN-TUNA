<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $table = 'kategori_produks';
    protected $primaryKey = 'kategori_produk_id';
    protected $fillable = ['nama_produk'];
    public $timestamps = true;

    public function cuttings()
    {
        return $this->hasMany(Cutting::class, 'kategori_produk_id');
    }
}