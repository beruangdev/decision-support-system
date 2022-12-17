<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }
    
    public function village()
    {
        return $this->hasMany(Village::class);
    }
    
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}
