<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto bg-gray-300 rounded-xl m-5">
        <h2 class="text-xl text-blue-700 font-black">Historial Médico de {{ $pet->name }}</h2>
        <div
            class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md bg-clip-border rounded-xl mt-4 overflow-auto">
            <table class="w-full text-left table-auto min-w-max dark:border-gray-700/60">
                <thead>
                    <tr class="border-b border-blue-gray-100 bg-blue-gray-50">
                        <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Fecha</p>
                        </th>
                        <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Veterinario</p>
                        </th>
                        <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Servicio</p>
                        </th>
                        <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                Diagnosticos</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consultations as $consultation)
                        <tr class="even:bg-blue-gray-50/50">
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $consultation->consultation_date }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $consultation->user->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $consultation->service->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $consultation->diagnostico }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
