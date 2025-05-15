<div class="flex flex-col col-span-full sm:col-span-6 p-5 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Servicios más consumidos por tipo de animal</h3>

    <div class="flex flex-wrap items-center gap-4 mb-4">
        <div>
            <label class="text-sm text-gray-700 dark:text-gray-200">Desde</label>
            <input wire:model="startDate" type="date" class="border rounded px-2 py-1 text-sm">
        </div>
        <div>
            <label class="text-sm text-gray-700 dark:text-gray-200">Hasta</label>
            <input wire:model="endDate" type="date" class="border rounded px-2 py-1 text-sm">
        </div>
        <div>
            <label class="text-sm text-gray-700 dark:text-gray-200">Tipo de animal</label>
            <select wire:model="animalTypeId" class="border rounded  py-1 text-sm">
                @foreach($animalTypes as $type)
                    <option value="{{ $type->id }}" class="px-3">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <button wire:click="exportToExcelRaw" class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1 rounded">
            Exportar a Excel
        </button>
    </div>

    <canvas id="servicesChart" width="400" height="200"></canvas>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let chartInstance = null;

            window.addEventListener('chartUpdated', (event) => {
                const { labels, data } = event.detail;
                const ctx = document.getElementById('servicesChart').getContext('2d');

                if (chartInstance) {
                    chartInstance.destroy();
                }

                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Cantidad de consultas',
                            data: data,
                            backgroundColor: 'rgb(132, 112, 255)',
                            borderColor: 'rgb(132, 112, 255)',
                            borderWidth: 1,
                            borderRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
