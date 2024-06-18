<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerMatch extends Model
{
    use HasFactory;

    protected $fillable = ['player_id', 'match_id'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
