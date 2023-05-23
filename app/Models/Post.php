<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,HasUuids;
    public $table = 'posts';

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'body'
    ];

    protected $casts = [
        'id'=> 'string',
        'user_id'=>'string',
        'title' => 'string',
        'body' => 'string'
    ];

    public function user() 
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function tags()
    {
       return $this->hasMany(\App\Models\Tag::class);
    }

    public function comments() 
    {
        return $this->hasMany(\App\Models\Comment::class);
    }
}
