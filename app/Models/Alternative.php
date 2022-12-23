<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function alternative_taxonomies()
    {
        return $this->hasMany(AlternativeTaxonomie::class, "alternative_id", "id");
    }

}
