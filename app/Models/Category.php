<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title', 'slug', 'status', 'icon_id', 'parent_id', 
    ];
    public function getRouteKeyName(){
        return 'slug';
    } 
    public function childs() {
        return $this->hasMany(self::class, 'parent_id','id');
    }
    public function parents() {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }
    public function post() {
        return $this->hasMany(Post::class);
    }
    public function icon() {
        return $this->belongsTo(Icon::class);
    }
    public function tag() {
        return $this->morphToMany(Tag::class, "tagable");
    }
    public function images() {
        return $this->morphMany(Image::class, "imageable");
    }
}
