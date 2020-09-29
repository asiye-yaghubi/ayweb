<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagable extends Model
{
    protected $fillable = [
        'tag_id','tagable_id','tagable_type',
    ];
}
