<div class="flex flex-col col-span-full sm:col-span-6 p-5 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <h3 class="text-lg font-semibold mb-4">Servicios más consumidos</h3>

    <div class="flex items-center gap-2 mb-4">
        <button wire:click="exportToExcelRaw"
            class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1 rounded ml-3">
            Exportar a Excel
        </button>
    </div>

    <canvas id="servicesChart" width="400" height="200"></canvas>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('servicesChart').getContext('2d');

                const chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            label: 'Cantidad de consultas',
                            data: @json($data),
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
