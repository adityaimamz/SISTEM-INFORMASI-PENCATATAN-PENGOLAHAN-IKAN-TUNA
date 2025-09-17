<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeL extends Model
{
    use HasFactory;

    protected $table = 'grade_sizings';
    protected $primaryKey = 'grade_size_id';
    protected $fillable = ['grade_sizing'];
    public $timestamps = false;
}