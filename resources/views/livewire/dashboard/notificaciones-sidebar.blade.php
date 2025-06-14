<div wire:poll.60s>
    <h2 class="text-lg font-bold mb-2">Todas las notificaciones</h2>
    <ul class="space-y-2">
        @forelse ($notificaciones as $n)
            <li class="p-2 border rounded">
                <strong>{{ $n->data['titulo'] }}</strong><br>
                <span>{{ $n->data['mensaje'] }}</span>
            </li>
        @empty
            <li class="text-gray-500">No hay notificaciones.</li>
        @endforelse
    </ul>
</div>
