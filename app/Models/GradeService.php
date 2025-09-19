<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeService extends Model
{
    use HasFactory;

    protected $table = 'grade_services';
    protected $primaryKey = 'grade_service_id';
    protected $fillable = ['grade_service'];
    public $timestamps = true;
}
