<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Floor;
use Illuminate\Http\Request;

class AscensorController extends Controller
{
    public function index()
    {
        // Traer pisos y tarjetas con sus relaciones
        $floors = Floor::with('cards')->orderBy('floor_number')->get();
        $cards = Card::with('floors')->get();

        return view('ascensores.index', compact('floors', 'cards'));
    }

    public function updateAccess(Request $request)
    {
        $request->validate([
            'card_id' => 'required|exists:cards,id',
            'floor_ids' => 'array',
            'floor_ids.*' => 'exists:floors,id',
        ]);

        $card = Card::findOrFail($request->card_id);
        $card->floors()->sync($request->floor_ids ?? []);

        return redirect()->route('ascensores.index')->with('success', 'Accesos actualizados correctamente.');
    }
}
