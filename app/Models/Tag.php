<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable=["team_id","name"];

    public function posts(){
        return $this->belongsToMany(Post::class, "post_tags");
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
