<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriByprodukCt extends Model
{
    use HasFactory;

    protected $primaryKey = 'kategori_byproduk_id';
    protected $guarded = [];

    public function kategoriByprodukCt()
    {
        return $this->hasMany(Cutting::class);
    }
}
