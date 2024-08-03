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
        return $this->belongsTo(Cutting::class, 'no_batch_id', 'id'); // corrected to use 'id'
    }

    public function ikan()
    {
        return $this->belongsTo(Kategori_ikan::class, 'id_ikan', 'id');
    }


    public function kode_trace()
    {
        return $this->belongsTo(KodeTrace::class, 'kode_trace_id', 'id');
    }

    public function packing()
    {
        return $this->hasMany(Packing::class, 'kode_trace_id', 'id');
    }
}
