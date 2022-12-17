<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function project_methods()
    {
        return $this->hasMany(ProjectMethod::class);
    }
}
