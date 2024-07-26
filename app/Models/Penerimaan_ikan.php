<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan_ikan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kategori_ikan()
    {
        return $this->belongsTo(Kategori_ikan::class, 'ikan_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
