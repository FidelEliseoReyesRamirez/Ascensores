<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Control de Comando</title>
</head>
<body>
    <h1>Comando actual: {{ $comando }}</h1>

    @if(session('mensaje'))
        <p style="color: green;">{{ session('mensaje') }}</p>
    @endif

    <form action="{{ route('comando.store') }}" method="POST">
        @csrf
        <input type="text" name="comando" placeholder="Escribe un comando" required />
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
