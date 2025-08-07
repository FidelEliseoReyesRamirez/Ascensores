<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ComandoController extends Controller
{
    // Mostrar formulario o página con comando actual
    public function index()
    {
        $comando = Cache::get('comando_actual', 'ninguno');
        return view('comando.index', compact('comando'));
    }

    // Guardar comando enviado desde formulario
    public function store(Request $request)
    {
        $request->validate([
            'comando' => 'required|string|max:255',
        ]);

        Cache::put('comando_actual', $request->comando);

        return redirect()->back()->with('mensaje', 'Comando guardado correctamente');
    }

    // Opcional: endpoint para obtener comando actual en JSON
    public function getComando()
    {
        $comando = Cache::get('comando_actual', 'ninguno');
        return response()->json(['comando' => $comando]);
    }
}
