<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
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

    // BELUM SEMPURNA
    public function criteria_rasio_1()
    {
        return $this->hasMany(CriteriaRasio::class, "criteria_id_1");
    }
    public function criteria_rasio_2()
    {
        return $this->hasMany(CriteriaRasio::class, "criteria_id_2");
    }

    public function criteria_rasios()
    {
        // return $this->hasManyThrough(CriteriaRasio::class, Criteria::class, "id", "criteria_id_1", "id", "id");
        // return $this->belongsToMany(CriteriaRasio::class, "criteria_rasios");
        // return $this->join('criteria_rasios as cr', 'cr.criteria_id_1', 'criterias.id');
    }

    public function project_method()
    {
        return $this->belongsTo(ProjectMethod::class);
    }


}
