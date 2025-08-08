@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Gestión de Ascensores</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 p-2">Tarjeta UID</th>
                <th class="border border-gray-300 p-2">Nombre Titular</th>
                <th class="border border-gray-300 p-2">Pisos Permitidos</th>
                <th class="border border-gray-300 p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cards as $card)
            <tr>
                <form action="{{ route('ascensores.updateAccess') }}" method="POST">
                    @csrf
                    <td class="border border-gray-300 p-2">{{ $card->uid }}</td>
                    <td class="border border-gray-300 p-2">{{ $card->holder_name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 p-2">
                        @foreach($floors as $floor)
                            <label class="inline-flex items-center mr-4">
                                <input type="checkbox" name="floor_ids[]" value="{{ $floor->id }}" {{ $card->floors->contains($floor->id) ? 'checked' : '' }}>
                                <span class="ml-1">Piso {{ $floor->floor_number }} {{ $floor->description ? ' - '.$floor->description : '' }}</span>
                            </label>
                        @endforeach
                    </td>
                    <td class="border border-gray-300 p-2">
                        <input type="hidden" name="card_id" value="{{ $card->id }}">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Actualizar</button>
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
