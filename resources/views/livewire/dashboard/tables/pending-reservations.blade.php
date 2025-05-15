<div wire:poll.5s class="flex flex-col col-span-full sm:col-span-6 p-5 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <h2 class="text-lg font-semibold mb-4">Reservas pendientes de hoy</h2>

    @if ($todayReservations->isEmpty())
        <p class="text-gray-500">No hay reservas pendientes para hoy.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach ($todayReservations as $res)
                <li class="py-2 flex justify-between items-center">
                    <div>
                        <p class="font-semibold">{{ $res->customer->name }} - {{ $res->pet->name }}</p>
                        <p class="text-sm text-gray-500">Hora:
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $res->start_time)->format('H:i') }}</p>
                    </div>
                    <span class="text-sm text-blue-600">
                        {{ \Carbon\Carbon::now()->diffForHumans(
                            \Carbon\Carbon::createFromFormat('H:i:s', $res->start_time)->timezone('America/Lima'),
                            ['parts' => 2, 'join' => true, 'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW],
                        ) }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
