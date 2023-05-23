<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory,HasUuids;

    public $table = 'comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'body'
    ];

    protected $casts = [
        'body' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class);
    }
}
