<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;
    protected $guarded = [];

    // BELUM SEMPURNA
    public function criteria_rasio_1()
    {
        return $this->hasMany(CriteriaRasio::class);
    }
    public function criteria_rasio_2()
    {
        return $this->hasMany(CriteriaRasio::class);
    }
    public function project_method()
    {
        return $this->belongsTo(ProjectMethod::class);
    }


}
