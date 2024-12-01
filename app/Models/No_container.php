<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class No_container extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function produkKeluar()
    {
        return $this->hasMany(produk_keluar::class, 'no_container_id');
    }
}
