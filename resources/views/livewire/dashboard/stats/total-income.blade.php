<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6">
    <div class="flex justify-between">
        <h5 class="text-xl text-gray-400">{{ $title }}</h5>
        <img src="{{ asset($icon) }}" alt="Ícono" class="w-6 h-6 mr-2">
    </div>

    <p class="text-2xl text-black dark:text-white font-bold">S/ {{ number_format($value, 2) }}</p>
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">Total generado por servicios prestados</p>

    {{-- Mini gráfico de los últimos 7 días --}}
    <div class="mt-4">
        <canvas id="miniIncomeChart" height="0" width="100%"></canvas>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('miniIncomeChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($recentLabels),
                        datasets: [{
                            data: @json($recentData),
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: context => `S/ ${context.formattedValue}`
                                }
                            }
                        },
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
