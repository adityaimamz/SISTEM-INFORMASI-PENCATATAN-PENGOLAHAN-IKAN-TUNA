<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan_ikan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ikan()
    {
        return $this->belongsTo(Ikan::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
