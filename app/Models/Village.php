<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }
    
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
