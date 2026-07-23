<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        "title",
        "slug",
        "category_id",
        "color",
        "body",
        "image",
        "published",
        "published_at",
    ];
    protected $casts = [
        "published" => "boolean",
        "published_at" => "datetime"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, "post_tags");
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
