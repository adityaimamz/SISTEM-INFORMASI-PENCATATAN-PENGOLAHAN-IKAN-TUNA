<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBeratPenerimaan extends Model
{
    use HasFactory;

    protected $table = 'kategori_berat_penerimaans';
    protected $primaryKey = 'kategori_berat_id';
    protected $fillable = ['kategori_berat'];

    public function penerimaan_ikans()
    {
        return $this->hasMany(PenerimaanIkan::class);
    }

}
