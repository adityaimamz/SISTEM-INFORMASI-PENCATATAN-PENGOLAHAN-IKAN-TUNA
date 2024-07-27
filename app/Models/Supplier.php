<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function penerimaan_ikan()
    {
        return $this->hasMany(Penerimaan_ikan::class, 'supplier_id', 'supplier_id');
    }
}
