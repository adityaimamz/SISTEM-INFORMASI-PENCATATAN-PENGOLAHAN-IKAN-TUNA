<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriByprodukCt extends Model
{
    use HasFactory;

    protected $table = 'kategori_byproduk_cts';
    protected $primaryKey = 'kategori_byproduk_id';
    protected $fillable = ['nama_produk'];
    public $timestamps = true;

    public function cuttings()
    {
        return $this->hasMany(Cutting::class, 'kategori_byproduk_id');
    }
}
