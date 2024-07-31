<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan_ikan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function kategori_berat_penerimaan()
    {
        return $this->belongsTo(KategoriBeratPenerimaan::class, 'kategori_berat_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}
