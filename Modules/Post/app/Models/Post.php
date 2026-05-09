<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'author_name',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
