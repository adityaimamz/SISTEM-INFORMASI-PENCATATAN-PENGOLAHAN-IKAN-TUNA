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

    public function no_batch()
    {
        return $this->belongsTo(NoBatch::class, 'no_batch_id', 'id'); // corrected to use 'id'
    }
    
    public function services()
    {
        return $this->hasMany(Service::class, 'no_batch_id', 'id'); // corrected to use 'id'
    }
    
    public function kategori_berat()
    {
        return $this->belongsTo(KategoriBeratCutting::class, 'kategori_berat_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'grade_id');
    }
    public function tgl_injek_co()
    {
        return $this->belongsTo(Cutting::class, 'tgl_injek_co', 'tgl_injek_co');
    }
    public function tgl_cutting()
    {
        return $this->belongsTo(Cutting::class, 'tgl_cutting', 'tgl_cutting');
    }
    public function selectedSupplier()
    {
        return $this->belongsTo(Supplier::class, 'selectedSupplier', 'supplier_id');
    }   
    public function selectedGrade()
    {
        return $this->belongsTo(Grade::class, 'selectedGrade', 'grade_id');
    }
    public function selectedKategoriBerat()
    {
        return $this->belongsTo(KategoriBeratCutting::class, 'selectedKategoriBerat', 'kategori_berat_id');
    }
}
