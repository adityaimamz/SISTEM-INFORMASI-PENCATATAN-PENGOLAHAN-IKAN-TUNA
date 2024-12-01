<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokCS extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function service()
    {
        return $this->belongsTo(Service::class, 'kode_trace_id', 'id');
    }
}
