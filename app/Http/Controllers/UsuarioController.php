<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function restore($id)
{
    $usuario = User::findOrFail($id);

    if ($usuario->eliminado) {
        $usuario->eliminado = false;
        $usuario->save();

        return redirect()->back()->with('status', 'Usuario restaurado correctamente.');
    }

    return redirect()->back()->with('error', 'El usuario no está eliminado.');
}

    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255', Rule::unique('users')->ignore($usuario->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];

        if (!empty($validated['password'])) {
            $usuario->password = Hash::make($validated['password']);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('status', 'Usuario actualizado correctamente.');
    }
     public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255', Rule::unique('users')],
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('usuarios.index')->with('status', 'Usuario creado correctamente.');
    }
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
