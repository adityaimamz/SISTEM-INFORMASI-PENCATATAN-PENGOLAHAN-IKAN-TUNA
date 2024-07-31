<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBeratCutting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function cutting()
    {
        return $this->hasMany(Cutting::class);
    }
}
