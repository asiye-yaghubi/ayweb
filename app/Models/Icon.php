<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $fillable = [
        'class',
    ];
    public function category() {
        return $this->hasMany(Category::class);
    }
}
