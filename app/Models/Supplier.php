<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penerimaan_ikan;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'nama_supplier',
        'alamat',
    ];

    protected $primaryKey = 'supplier_id';


    public function penerimaan_ikan()
    {
        return $this->hasMany(Penerimaan_ikan::class, 'supplier_id', 'supplier_id')
        ->withTrashed();
    }

    public function getRouteKeyName()
    {
        return 'supplier_id';
    }
}
