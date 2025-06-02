<div>
    <h2 class="text-xl font-bold mb-4 text-gray-700">Control de Vacunas para {{ $pet->name }}</h2>

    <form wire:submit.prevent="save" class="space-y-4 mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Vacuna</label>
            <select wire:model="vaccine_id" class="input input-bordered w-full">
                <option value="">Seleccione una vacuna</option>
                @foreach($vaccines as $vaccine)
                    <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                @endforeach
            </select>
            @error('vaccine_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Fecha de aplicación</label>
            <input type="date" wire:model="application_date" class="input input-bordered w-full" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Notas</label>
            <textarea wire:model="notes" class="input input-bordered w-full"></textarea>
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" wire:model="with_deworming" id="deworming" class="form-checkbox" />
            <label for="deworming" class="text-sm text-gray-700">Aplicada con desparasitación</label>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Aplicación</button>
    </form>

    <hr class="my-6">

    <h3 class="text-lg font-semibold mb-2 text-gray-700">Historial de Aplicaciones</h3>
    <ul class="space-y-4">
        @foreach($applications as $app)
            <li class="p-4 bg-gray-100 rounded shadow-sm">
                <div class="font-semibold">{{ $app->vaccine->name }}</div>
                <div class="text-sm text-gray-600">
                    Aplicada el {{ \Carbon\Carbon::parse($app->application_date)->format('d/m/Y') }} por {{ $app->user->name }}
                </div>
                @if ($app->with_deworming)
                    <div class="text-green-600 text-sm">Incluyó desparasitación</div>
                @endif
                @if ($app->notes)
                    <div class="text-gray-700 text-sm mt-1"><strong>Notas:</strong> {{ $app->notes }}</div>
                @endif
            </li>
        @endforeach
    </ul>
</div>
