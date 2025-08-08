<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['uid', 'holder_name', 'active'];

    public function floors()
    {
        return $this->belongsToMany(Floor::class, 'card_floor');
    }
}
