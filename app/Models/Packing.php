<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Menggunakan no_box sebagai primary key

    public function service()
    {
        return $this->belongsTo(Service::class, 'kode_trace_id', 'id');
    }

   
}
