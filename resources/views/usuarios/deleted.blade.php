<x-layouts.app title="Usuarios eliminados">
    <div class="p-6 max-w-full">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-5">Usuarios eliminados</h1>

        <!-- Botón Volver -->
        <div class="mb-4">
            <a href="{{ route('usuarios.index') }}"
                class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Volver
            </a>
        </div>

        <div class="overflow-x-auto max-w-full rounded-lg border border-gray-300 dark:border-zinc-700">
            <table class="min-w-[700px] w-full divide-y divide-gray-200 dark:divide-zinc-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 dark:bg-zinc-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Eliminado</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $usuario->id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $usuario->name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $usuario->email }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $usuario->eliminado ? 'Sí' : 'No' }}</td>
                            <td class="px-4 py-2 text-center whitespace-nowrap">
                                <form action="{{ route('usuarios.restore', $usuario) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2 py-1 text-white bg-green-600 rounded hover:bg-green-700 transition text-xs" title="Restaurar usuario">
                                        Restaurar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No hay usuarios eliminados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $usuarios->appends(request()->query())->links() }}
        </div>
    </div>
</x-layouts.app>
