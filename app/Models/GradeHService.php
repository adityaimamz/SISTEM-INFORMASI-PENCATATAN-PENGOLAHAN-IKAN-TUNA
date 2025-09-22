<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeHService extends Model
{
    use HasFactory;

    protected $table = 'grade_servicehs';
    protected $primaryKey = 'grade_servicehs_id';
    protected $fillable = ['grading'];
    public $timestamps = false;
}