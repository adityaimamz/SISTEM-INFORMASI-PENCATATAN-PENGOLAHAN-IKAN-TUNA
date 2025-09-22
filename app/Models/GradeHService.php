<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeHService extends Model
{
    use HasFactory;

    protected $table = 'grade_servicehs';
    protected $primaryKey = 'grade_servicehs_id';
    protected $fillable = ['grade_servicehs'];
    public $timestamps = false;
}