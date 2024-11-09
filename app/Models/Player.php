<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 */
class Player extends Model
{
    protected $hidden = [
        'id'
    ];



    //=================================================================>
    public function maxScore(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\Quiz')->orderBy('score', 'desc')->take(1);
    }
    //=================================================================>
    public function Quiz(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Quiz');
    }
}
