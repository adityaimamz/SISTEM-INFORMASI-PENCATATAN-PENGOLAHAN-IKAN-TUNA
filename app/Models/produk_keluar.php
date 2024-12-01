<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk_keluar extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'kode_trace_id', 'id');
    }


    public function noContainer()
    {
        return $this->belongsTo(No_container::class, 'no_container_id', 'id');
    }
}
