<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $primaryKey = 'grade_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $guarded = ['grade_id'];

    public function penerimaan_ikans()
    {
        return $this->hasMany(PenerimaanIkan::class);
    }

    public function kategoriBerat()
    {
        return $this->belongsTo(KategoriBeratPenerimaan::class, 'kategori_berat_id');
    }
}
