<div class="bg-white shadow-md rounded-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6 dark:bg-gray-800">
    <!-- Foto de la mascota -->
    <div class="col-span-1 flex justify-center items-start">
        <img src="{{ $pet->photo ? Storage::url($pet->photo) : '' }}" 
             alt="Foto de {{ $pet->name }}" 
             class="w-48 h-48 object-cover rounded-full border-2 border-blue-400 shadow-md">
    </div>

    <!-- Formulario para subir foto -->
    <div class="col-span-1 flex flex-col justify-center items-center space-y-4">
        <form wire:submit.prevent="savePhoto" class="flex flex-col items-center space-y-4">
            <input type="file" wire:model="photo" class="border p-2 rounded" accept="image/*">
            @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Subir Foto</button>
        </form>
        @if (session()->has('message'))
            <div class="text-green-600 mt-4">{{ session('message') }}</div>
        @endif
    </div>

    <!-- Datos de la mascota -->
    <div class="col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <h3 class="text-gray-600 font-semibold dark:text-gray-100">Nombre</h3>
            <p class="text-lg text-gray-800 dark:text-gray-100">{{ $pet->name }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold dark:text-gray-100">Especie</h3>
            <p class="text-lg text-gray-800 dark:text-gray-100">{{ $pet->animaltype->name ?? '-' }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold dark:text-gray-100">Raza</h3>
            <p class="text-lg text-gray-800 dark:text-gray-100">{{ $pet->breed }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold dark:text-gray-100">Edad</h3>
            <p class="text-lg text-gray-800 dark:text-gray-100">{{ $pet->age }} años</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold dark:text-gray-100">Género</h3>
            <p class="text-lg text-gray-800 dark:text-gray-100">{{ $pet->sex }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold dark:text-gray-100">Esterilizado</h3>
            <p class="text-lg text-gray-800 dark:text-gray-100">
                {{ $pet->sterilized ? 'Sí' : 'No' }}
            </p>
        </div>
    </div>

    <!-- Datos del dueño -->
    <div class="col-span-3 mt-6 border-t pt-4">
        <h3 class="text-blue-600 text-lg font-bold mb-2 dark:text-gray-100">Datos del Propietario</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <h4 class="text-gray-600 font-semibold dark:text-gray-100">Nombre</h4>
                <p class="text-gray-800 dark:text-gray-100">{{ $pet->owner->name }}</p>
            </div>
            <div>
                <h4 class="text-gray-600 font-semibold dark:text-gray-100">Teléfono</h4>
                <p class="text-gray-800 dark:text-gray-100">{{ $pet->owner->phone }}</p>
            </div>  
            <div>
                <h4 class="text-gray-600 font-semibold dark:text-gray-100">Email</h4>
                <p class="text-gray-800 dark:text-gray-100">
                    @if ($pet->owner->email)
                        {{ $pet->owner->email }}
                    @else
                        No tiene email
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Última Consulta -->
    @if($lastConsultation)
    <div class="col-span-3 mt-6 border-t pt-4">
        <h3 class="text-green-600 text-lg font-bold mb-4 dark:text-gray-100">Última Consulta</h3>
        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <h4 class="text-gray-600 font-semibold dark:text-gray-100">Fecha</h4>
                    <p class="text-gray-800 dark:text-gray-100">
                        {{ \Carbon\Carbon::parse($lastConsultation->consultation_date)->format('d/m/Y') }}
                    </p>
                </div>
                <div>
                    <h4 class="text-gray-600 font-semibold dark:text-gray-100">Peso</h4>
                    <p class="text-gray-800 dark:text-gray-100">
                        {{ $lastConsultation->peso ? $lastConsultation->peso . ' kg' : 'No registrado' }}
                    </p>
                </div>
                <div>
                    <h4 class="text-gray-600 font-semibold dark:text-gray-100">Temperatura</h4>
                    <p class="text-gray-800 dark:text-gray-100">
                        {{ $lastConsultation->temperatura ? $lastConsultation->temperatura . '°C' : 'No registrada' }}
                    </p>
                </div>
                <div>
                    <h4 class="text-gray-600 font-semibold dark:text-gray-100">Estado General</h4>
                    <p class="text-gray-800 dark:text-gray-100">
                        {{ $lastConsultation->estado_general ?? 'No registrado' }}
                    </p>
                </div>
            </div>
            @if($lastConsultation->observations)
            <div class="mt-4">
                <h4 class="text-gray-600 font-semibold dark:text-gray-100">Observaciones</h4>
                <p class="text-gray-800 dark:text-gray-100">{{ $lastConsultation->observations }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Historial de Consultas -->
    @if($consultations->count() > 0)
    <div class="col-span-3 mt-6 border-t pt-4">
        <h3 class="text-purple-600 text-lg font-bold mb-4 dark:text-gray-100">Historial de Consultas</h3>
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Peso</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Temp.</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">F.C.</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">F.R.</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($consultations as $consultation)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-3 py-2 text-xs text-gray-800 dark:text-gray-100 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-3 py-2 text-xs text-gray-800 dark:text-gray-100">
                                {{ $consultation->peso ? $consultation->peso . 'kg' : '-' }}
                            </td>
                            <td class="px-3 py-2 text-xs text-gray-800 dark:text-gray-100">
                                {{ $consultation->temperatura ? $consultation->temperatura . '°' : '-' }}
                            </td>
                            <td class="px-3 py-2 text-xs text-gray-800 dark:text-gray-100">
                                {{ $consultation->frecuencia_cardiaca ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-xs text-gray-800 dark:text-gray-100">
                                {{ $consultation->frecuencia_respiratoria ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-xs text-gray-800 dark:text-gray-100">
                                <span class="inline-block max-w-20 truncate" title="{{ $consultation->estado_general ?? '-' }}">
                                    {{ $consultation->estado_general ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-span-3 mt-6 border-t pt-4">
        <div class="text-center py-8">
            <p class="text-gray-500 dark:text-gray-400">No hay consultas registradas para esta mascota.</p>
        </div>
    </div>
    @endif
</div>
    