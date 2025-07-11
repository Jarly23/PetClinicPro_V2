<div class="col-span-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5">
    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-4">Ingresos por Año</h3>
    <canvas id="yearlyIncomeChart" height="200"></canvas>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('yearlyIncomeChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            label: 'Ingresos anuales (S/)',
                            data: @json($data),
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let year = context.label;
                                        let value = context.formattedValue;
                                        return `Ingresos en ${year}: S/ ${value}`;
                                    }
                                }
                            },
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Evolución de ingresos anuales'
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
