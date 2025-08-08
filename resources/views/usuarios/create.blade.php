<x-layouts.app title="Crear usuario">
    <div class="p-6 max-w-full">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-5">Crear usuario</h1>

        <form action="{{ route('usuarios.store') }}" method="POST" class="max-w-lg space-y-6">
            @csrf

            <div>
                <label for="name" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500" />
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2 border rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500" />
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500" />
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-3 py-2 border rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="flex gap-2">
                <a href="{{ route('usuarios.index') }}"
                    class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">Cancelar</a>
                <button type="submit"
                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Guardar</button>
            </div>
        </form>
    </div>
</x-layouts.app>
