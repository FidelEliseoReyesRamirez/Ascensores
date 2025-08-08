<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = ['floor_number', 'description'];

    public function cards()
    {
        return $this->belongsToMany(Card::class, 'card_floor');
    }
}
