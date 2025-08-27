<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penerimaan_ikans()
    {
        return $this->hasMany(PenerimaanIkan::class);
    }

    public function kategoriBerat()
    {
        return $this->belongsTo(KategoriBeratPenerimaan::class, 'kategori_berat_id');
    }
}
