<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory,HasUUids;

    public $table = 'follows';

    protected $fillable = [
       'follower_id',
       'following_id', 
    ];

    public function follower() 
    {
        return $this->belongsTo(\App\Models\User::class,'follower_id');
    }

    public function following() 
    {
        return $this->belongsTo(\App\Models\User::class,'following_id');
    }
}
