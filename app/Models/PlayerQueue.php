<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlayerQueue extends Model
{
    public function Player(): HasOne
    {
        return $this->hasOne(Player::class,'id','player_id');
    }
}
