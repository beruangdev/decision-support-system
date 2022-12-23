<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculate extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (is_null($post->user_id)) {
                $post->user_id = auth()->user()->id;
            }
        });
    }


    public function filter()
    {
        return $this->hasMany(Filter::class);
    }

    public function algorithm()
    {
        return $this->belongsTo(Algorithm::class);
    }

    public function project_method()
    {
        return $this->belongsTo(ProjectMethod::class);
    }
}
