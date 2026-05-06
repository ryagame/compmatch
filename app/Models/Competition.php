<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'category', 'deadline', 'poster'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lobbies()
    {
        return $this->hasMany(Lobby::class);
    }
}