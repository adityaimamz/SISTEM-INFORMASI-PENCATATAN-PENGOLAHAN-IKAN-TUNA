<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuttingL extends Model
{
    protected $table = 'cutting_ls';
    protected $primaryKey = 'cuttingl_id';
    protected $fillable = [
        'tggl_cutting',
        'tggl_injek_co',
        'tggl_service',
        'grade_size_id',
        'berat_loin',
        'suhu_loin',
        'penerimaan_id',
        'created_at',
        'updated_at'
    ];

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan_ikan::class, 'penerimaan_id', 'penerimaan_id');
    }

    public function grade_size()
    {
        return $this->belongsTo(GradeSizing::class, 'grade_size_id', 'grade_size_id');
    }
}