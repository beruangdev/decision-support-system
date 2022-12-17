<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }

    public function kabupatens()
    {
        return $this->hasMany(Kabupaten::class);
    }
}
