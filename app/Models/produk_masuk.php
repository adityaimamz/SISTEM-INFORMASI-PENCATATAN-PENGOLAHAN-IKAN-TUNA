<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk_masuk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function packing()
    {
        return $this->belongsTo(Packing::class, 'no_box');
    }

    
}
