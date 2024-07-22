<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['kode_lot'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function cutting()
    {
        return $this->belongsTo(Cutting::class, 'no_batch', 'no_batch'); // Ensure both local and foreign keys match
    }

    public function detail()
    {
        return $this->belongsTo(DetailProduk::class, 'id_detail');
    }

    public function packing()
    {
        return $this->hasMany(Packing::class, 'kode_lot');
    }
}
