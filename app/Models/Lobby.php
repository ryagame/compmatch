<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lobby extends Model
{
    protected $fillable = [
        'competition_id', 'user_id', 'name', 'max_members'
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(LobbyMember::class);
    }

    public function skillSlots()
    {
        return $this->hasMany(SkillSlot::class);
    }
}