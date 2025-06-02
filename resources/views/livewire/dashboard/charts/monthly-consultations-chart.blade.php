<div class="col-span-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-100">Evolución Mensual de Ingresos</h3>
        <select wire:model="selectedYear" class="border border-gray-300 rounded py-1 text-sm">
            @foreach ($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </div>

    <canvas id="incomeChart" height="200"></canvas>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('incomeChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            label: 'Ingresos (S/)',
                            data: @json($data),
                            backgroundColor: 'rgba(132, 112, 255, 0.2)',
                            borderColor: 'rgb(132, 112, 255)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
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
