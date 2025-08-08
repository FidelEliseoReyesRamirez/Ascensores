<x-layouts.app :title="__('Usuarios')">
    <div class="p-6 max-w-full">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-5">{{ __('Listado de usuarios') }}</h1>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">

            <div class="flex flex-wrap gap-3 items-center">
                <a href="{{ route('usuarios.create') }}"
                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    {{ __('Crear usuario') }}
                </a>

                <a href="{{ route('usuarios.deleted') }}"
                    class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    {{ __('Ver eliminados') }}
                </a>

                <form id="filterForm" method="GET" action="{{ route('usuarios.index') }}"
                    class="flex flex-wrap items-center gap-2">

                    <label for="search_column" class="sr-only">Buscar por</label>
                    <select name="search_column" id="search_column"
                        class="px-3 py-2 border rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="id" {{ request('search_column') == 'id' ? 'selected' : '' }}>
                            {{ __('ID') }}
                        </option>
                        <option value="name" {{ request('search_column') == 'name' ? 'selected' : '' }}>
                            {{ __('Nombre') }}</option>
                        <option value="email" {{ request('search_column') == 'email' ? 'selected' : '' }}>
                            {{ __('Email') }}</option>
                        <option value="created_range"
                            {{ request('search_column') == 'created_range' ? 'selected' : '' }}>
                            {{ __('Rango de fechas de creación') }}</option>
                    </select>

                    <!-- Campo texto para búsqueda por nombre o email -->
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="{{ __('Buscar...') }}"
                        class="px-3 py-2 border rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                        autocomplete="off" {{ request('search_column') === 'created_range' ? 'disabled' : '' }} />

                    <!-- Campos de rango de fechas, solo visibles si se selecciona 'created_range' -->
                    <div id="dateRangeFields" class="flex gap-2 items-center" style="display: none;">
                        <label for="date_start" class="sr-only">{{ __('Fecha inicio') }}</label>
                        <input type="date" name="date_start" id="date_start" value="{{ request('date_start') }}"
                            class="px-3 py-2 border rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500" />

                        <label for="date_end" class="sr-only">{{ __('Fecha fin') }}</label>
                        <input type="date" name="date_end" id="date_end" value="{{ request('date_end') }}"
                            class="px-3 py-2 border rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <button type="submit"
                        class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        {{ __('Buscar') }}
                    </button>
                    <button type="button" id="btnClearFilters"
                        class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition ml-2">
                        {{ __('Limpiar') }}
                    </button>

                </form>

                <form method="GET" action="{{ route('usuarios.index') }}" class="flex items-center space-x-1">
                    <label for="filterBloqueado"
                        class="text-gray-700 dark:text-gray-300">{{ __('Bloqueados') }}</label>
                    <input type="checkbox" id="filterBloqueado" name="bloqueado" value="1"
                        onchange="this.form.submit()" {{ request('bloqueado') ? 'checked' : '' }}
                        class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500" />
                </form>


            </div>
        </div>
        <!-- Contenedor para scroll horizontal solo de la tabla -->
        <div class="overflow-x-auto max-w-full rounded-lg border border-gray-300 dark:border-zinc-700">
            <table
                class="min-w-[700px] w-full divide-y divide-gray-200 dark:divide-zinc-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 dark:bg-zinc-700">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            ID</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Nombre') }}</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Email') }}</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Creado') }}</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Bloqueado') }}</th>

                        <th
                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                {{ $usuario->id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $usuario->name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                {{ $usuario->email }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                {{ $usuario->created_at->format('d/m/Y') }}</td>

                            <td class="px-4 py-2 text-center">
                                <input type="checkbox" disabled {{ $usuario->bloqueado ? 'checked' : '' }}
                                    class="mx-auto h-5 w-5 text-blue-600 rounded border-gray-300" />
                            </td>


                            <td class="px-4 py-2 text-center space-x-1 whitespace-nowrap">
                                <a href="{{ route('usuarios.edit', $usuario) }}"
                                    class="inline-block px-2 py-1 text-white bg-green-600 rounded hover:bg-green-700 transition text-xs"
                                    title="{{ __('Editar') }}">
                                    {{ __('Editar') }}
                                </a>

                                <form action="{{ route('usuarios.toggleBloqueo', $usuario) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-block px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600 transition text-xs"
                                        title="{{ $usuario->bloqueado ? __('Desbloquear') : __('Bloquear') }}">
                                        {{ $usuario->bloqueado ? __('Desbloquear') : __('Bloquear') }}
                                    </button>
                                </form>

                                @if (!$usuario->eliminado)
                                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST"
                                        class="inline delete-user-form"
                                        data-action="{{ route('usuarios.destroy', $usuario) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="inline-block px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700 transition text-xs"
                                            title="{{ __('Eliminar') }}">
                                            {{ __('Eliminar') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">{{ __('Eliminado') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No se encontraron usuarios.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $usuarios->appends(request()->query())->links() }}
        </div>
    </div>
    <!-- Modal Error -->
    <div id="modalError" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-sm w-full text-center">
            <h3 class="text-lg font-semibold mb-4 text-red-600">{{ __('Error') }}</h3>
            <p class="mb-6 text-gray-700 dark:text-gray-300" id="modalErrorMessage"></p>
            <button id="closeErrorBtn"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 dark:bg-zinc-600 dark:hover:bg-zinc-500">
                {{ __('Cerrar') }}
            </button>
        </div>
    </div>

    <!-- Modal Confirmación Eliminar -->
    <div id="modalDelete" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-sm w-full text-center">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Confirmar eliminación</h3>
            <p class="mb-6 text-gray-700 dark:text-gray-300">¿Seguro que quieres eliminar este usuario?</p>
            <div class="flex justify-center gap-4">
                <button id="cancelDeleteBtn"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 dark:bg-zinc-600 dark:hover:bg-zinc-500">Cancelar</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // --- Modal error ---
        const modalError = document.getElementById('modalError');
        const closeErrorBtn = document.getElementById('closeErrorBtn');
        const modalErrorMessage = document.getElementById('modalErrorMessage');

        @if (session('error'))
            modalErrorMessage.textContent = @json(session('error'));
            modalError.classList.remove('hidden');
            modalError.classList.add('flex');
        @endif

        closeErrorBtn.addEventListener('click', () => {
            modalError.classList.add('hidden');
            modalError.classList.remove('flex');
        });

        // También cerrar modal error si clic fuera del contenido
        modalError.addEventListener('click', (e) => {
            if (e.target === modalError) {
                modalError.classList.add('hidden');
                modalError.classList.remove('flex');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modalDelete');
            const cancelBtn = document.getElementById('cancelDeleteBtn');
            const deleteForm = document.getElementById('deleteForm');

            document.querySelectorAll('.delete-user-form button').forEach(button => {
                button.addEventListener('click', (e) => {
                    const form = e.target.closest('form');
                    const action = form.getAttribute('data-action');
                    deleteForm.setAttribute('action', action);
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            cancelBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            // Cerrar modal si clic fuera del contenido
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            const searchColumn = document.getElementById('search_column');
            const searchInput = document.getElementById('search');
            const dateRangeFields = document.getElementById('dateRangeFields');
            const dateStart = document.getElementById('date_start');
            const dateEnd = document.getElementById('date_end');

            // Mostrar/Ocultar campos de rango de fechas y activar/desactivar input texto según opción seleccionada
            function toggleFields() {
                if (searchColumn.value === 'created_range') {
                    dateRangeFields.style.display = 'flex';
                    searchInput.disabled = true;
                    searchInput.value = '';
                } else {
                    dateRangeFields.style.display = 'none';
                    searchInput.disabled = false;
                }
            }
            toggleFields(); // Ejecutar al cargar la página

            searchColumn.addEventListener('change', toggleFields);

            // Restringir selección de fechas para evitar fechas inválidas
            dateStart.addEventListener('change', () => {
                if (dateStart.value) {
                    dateEnd.min = dateStart.value;
                } else {
                    dateEnd.min = '';
                }
            });

            dateEnd.addEventListener('change', () => {
                if (dateEnd.value) {
                    dateStart.max = dateEnd.value;
                } else {
                    dateStart.max = '';
                }
            });
        });
        document.getElementById('btnClearFilters').addEventListener('click', () => {
            const form = document.getElementById('filterForm');

            // Resetear el formulario (limpia todos los inputs)
            form.reset();

            // Como el select cambia, debemos ejecutar toggleFields para ajustar la visibilidad y estado de inputs
            const event = new Event('change');
            form.querySelector('#search_column').dispatchEvent(event);

            // Enviar formulario para recargar la página sin filtros
            form.submit();
        });
    </script>
</x-layouts.app>
