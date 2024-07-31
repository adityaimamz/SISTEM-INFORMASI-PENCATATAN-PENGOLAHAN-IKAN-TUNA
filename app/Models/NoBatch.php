<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoBatch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function cuttings()
    {
        return $this->hasMany(Cutting::class);
    }
}
