<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuttingL extends Model
{
    use HasFactory;

    protected $table = 'cuttingls';
    protected $primaryKey = 'cuttingl_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'tggl_cutting',
        'tggl_injek_co',
        'tggl_service',
        'penerimaan_id',
        'grade_size_id',
        'berat_loin',
        'suhu_loin',
    ];

    public function grade_size()
    {
        return $this->belongsTo(GradeSize::class, 'grade_size_id');
    }

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan_ikan::class, 'penerimaan_id');
    }
}

