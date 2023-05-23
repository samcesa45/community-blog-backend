<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory,HasUuids;

    public $table = 'tags';

    protected $fillable = [
        'name'
    ];

    public function posts() 
    {
        return $this->belongsToMany(\App\Models\Post::class);
    }
}
