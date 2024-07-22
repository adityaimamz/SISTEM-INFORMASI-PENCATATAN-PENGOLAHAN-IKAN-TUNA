<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penerimaan_ikan()
    {
        return $this->belongsTo(Penerimaan_ikan::class, 'id_produk');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'no_batch', 'no_batch'); // Ensure both local and foreign keys match
    }
}
