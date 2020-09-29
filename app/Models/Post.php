<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'status', 'description', 'category_id', 'user_id'
    ];
    public function getRouteKeyName(){
        return 'slug';
    } 
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function tag() {
        return $this->morphToMany(Tag::class, "tagable");
    }
    public function images() {
        return $this->morphMany(Image::class, "imageable");
    }
}
