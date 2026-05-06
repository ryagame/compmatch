<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillSlot extends Model
{
    protected $fillable = [
        'lobby_id', 'skill_name', 'filled_by'
    ];

    public function lobby()
    {
        return $this->belongsTo(Lobby::class);
    }

    public function filledBy()
    {
        return $this->belongsTo(User::class, 'filled_by');
    }
}