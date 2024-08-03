<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeTrace extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function services()
    {
        return $this->hasMany(Service::class, 'kode_trace_id', 'id');
    }
}
