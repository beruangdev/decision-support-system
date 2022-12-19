<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function alternative_taxonomies()
    {
        return $this->hasMany(AlternativeTaxonomie::class, "alternative_id", "id");
    }

}
