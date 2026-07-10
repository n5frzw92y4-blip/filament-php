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
        "tags"
    ];
    protected $casts = [
        "tags" => "array",
        "published" => "boolean",
        "published_at" => "datetime"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
