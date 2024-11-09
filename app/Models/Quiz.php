<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $player_id
 * @property mixed|\Ramsey\Uuid\UuidInterface $uuid
 */
class Quiz extends Model
{
    protected $hidden = [
        'id','player_id'
    ];
    //=================================================================>
    public function QuizAnswer(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\QuizAnswer');
    }
    //=================================================================>
    public function Player(): HasOne
    {
        return $this->hasOne(Player::class,'id','player_id');
    }
    //=================================================================>
}
