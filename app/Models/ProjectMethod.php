<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMethod extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function calculates()
    {
        return $this->hasMany(Calculate::class);
    }

    public function criterias()
    {
        return $this->hasMany(Criteria::class);
    }

    public function method()
    {
        return $this->belongsTo(Method::class);
    }
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
