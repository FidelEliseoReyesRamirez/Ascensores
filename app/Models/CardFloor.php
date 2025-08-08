<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CardFloor extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'card_floors';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'card_id',
        'floor_id',
    ];

    /**
     * Relación con el modelo Card.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Relación con el modelo Floor.
     */
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }
}
