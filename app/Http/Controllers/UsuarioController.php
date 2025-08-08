<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Búsqueda dinámica según columna seleccionada
        if ($request->filled('search') || $request->input('search_column') === 'created_range') {
            $searchColumn = $request->input('search_column');
            $search = $request->input('search');

            switch ($searchColumn) {
                case 'id':
                    if (is_numeric($search)) {
                        $query->where('id', $search);
                    }
                    break;

                case 'name':
                    $query->where('name', 'like', "%$search%");
                    break;

                case 'email':
                    $query->where('email', 'like', "%$search%");
                    break;

                case 'created_range':
                    $start = $request->input('date_start');
                    $end = $request->input('date_end');
                    if ($start && $end) {
                        $query->whereBetween('created_at', [$start, $end]);
                    } elseif ($start) {
                        $query->where('created_at', '>=', $start);
                    } elseif ($end) {
                        $query->where('created_at', '<=', $end);
                    }
                    break;

                default:
                    // No hacer nada
                    break;
            }
        }
        // Filtrar solo bloqueados si está activo el filtro
        if ($request->boolean('bloqueado')) {
            $query->where('bloqueado', true);
        }

        // Filtrar eliminados si está activo el filtro, si no, mostrar solo no eliminados
        if ($request->boolean('eliminado')) {
            $query->where('eliminado', true);
        } else {
            $query->where('eliminado', false);
        }

        // Ordenar y paginar resultados (10 por página)
        $usuarios = $query->orderBy('id', 'desc')->paginate(10);

        // Mantener los parámetros GET en los enlaces de paginación
        $usuarios->appends($request->all());
        
        return view('usuarios.index', compact('usuarios'));
    }

    // Cambia el estado de bloqueo del usuario (toggle)
    public function toggleBloqueo(User $usuario)
    {
        $usuario->bloqueado = !$usuario->bloqueado;
        $usuario->save();

        return redirect()->back()->with('status', 'Estado de bloqueo actualizado.');
    }

    // Eliminación lógica del usuario (soft delete personalizado)
    public function destroy($id)
    {
        if ($id == Auth::user()->id) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $usuario = User::findOrFail($id);
        $usuario->eliminado = true;
        $usuario->save();

        return redirect()->back()->with('status', 'Usuario eliminado correctamente.');
    }

    // Vista para usuarios eliminados (opcional)
    public function deleted(Request $request)
    {
        $query = User::where('eliminado', true);

        // Aquí también podrías añadir filtros si quieres
        $usuarios = $query->orderBy('id', 'desc')->paginate(10);
        $usuarios->appends($request->all());

        return view('usuarios.deleted', compact('usuarios'));
    }
}
