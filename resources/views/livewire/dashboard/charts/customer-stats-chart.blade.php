<div class="col-span-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5">
    <div class="flex gap-2 mb-4">
        <button onclick="showChart('weekly')" class="bg-blue-500 text-white px-4 py-2 rounded">Semanal</button>
        <button onclick="showChart('monthly')" class="bg-green-500 text-white px-4 py-2 rounded">Mensual</button>
        <button onclick="showChart('yearly')" class="bg-yellow-500 text-white px-4 py-2 rounded">Anual</button>
    </div>

    <!-- Filtros -->
    <div id="chart-weekly-container">
        <h4 class="text-lg font-semibold text-blue-600 mb-2">Clientes por Semana</h4>
        <canvas id="chart-weekly" class="w-full h-64"></canvas>
    </div>

    <div id="chart-monthly-container" class="hidden">
        <h4 class="text-lg font-semibold text-green-600 mb-2">Clientes por Mes</h4>
        <canvas id="chart-monthly" class="w-full h-64"></canvas>
    </div>

    <div id="chart-yearly-container" class="hidden">
        <h4 class="text-lg font-semibold text-yellow-600 mb-2">Clientes por Año</h4>
        <canvas id="chart-yearly" class="w-full h-64"></canvas>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function showChart(type) {
            document.getElementById('chart-weekly-container').classList.add('hidden');
            document.getElementById('chart-monthly-container').classList.add('hidden');
            document.getElementById('chart-yearly-container').classList.add('hidden');

            document.getElementById(`chart-${type}-container`).classList.remove('hidden');
        }
        document.addEventListener('DOMContentLoaded', () => {
            const weeklyCtx = document.getElementById('chart-weekly').getContext('2d');
            const monthlyCtx = document.getElementById('chart-monthly').getContext('2d');
            const yearlyCtx = document.getElementById('chart-yearly').getContext('2d');

            new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: @json($weeklyData['labels']),
                    datasets: [{
                        label: 'Clientes esta semana',
                        data: @json($weeklyData['data']),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });

            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: @json($monthlyData['labels']),
                    datasets: [{
                        label: 'Clientes por mes',
                        data: @json($monthlyData['data']),
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true
                }
            });

            new Chart(yearlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($yearlyData['labels']),
                    datasets: [{
                        label: 'Clientes por año',
                        data: @json($yearlyData['data']),
                        backgroundColor: 'rgba(234, 179, 8, 0.5)',
                        borderColor: 'rgba(234, 179, 8, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>
@endpush
