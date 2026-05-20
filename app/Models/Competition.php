<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $table = 'competitions';
    protected $fillable = [
        'title',
        'description',
        'category',
        'deadline',
        'poster',
        'user_id',
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