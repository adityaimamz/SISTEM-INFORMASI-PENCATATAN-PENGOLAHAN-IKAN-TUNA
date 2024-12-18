<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function service()
    {
        return $this->hasMany(Service::class, 'services_id');
    }
}
