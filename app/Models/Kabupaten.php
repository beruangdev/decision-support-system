<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }
    
    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class);
    }
    
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

}
