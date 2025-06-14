<div class="min-h-screen bg-gray-100 p-2 dark:bg-gray-900">
  <div class="w-full space-y-4">

    
    <!-- Título -->
    <div class="text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-700 tracking-wide drop-shadow-sm">
        Control de Inventario
      </h1>
      <p class="text-gray-500 mt-1 text-base md:text-lg">
        Panel resumen de productos, ventas y movimientos
      </p>
    </div>

    <!-- Métricas -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Ventas del mes</p>
        <p class="text-xl font-bold text-gray-900">S/ {{ number_format($totalSalesMonth, 2) }}</p>
      </div>
      <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Compras del mes</p>
        <p class="text-xl font-bold text-gray-900">S/ {{ number_format($totalPurchasesMonth, 2) }}</p>
      </div>
      <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total productos</p>
        <p class="text-xl font-bold text-gray-900">{{ $totalProducts }}</p>
      </div>
      <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Stock total</p>
        <p class="text-xl font-bold text-gray-900">{{ number_format($stockTotal) }}</p>
      </div>
    </section>


      <!-- Sección: Ventas de hoy + Entradas/Salidas + Stock Bajo + productos por vencer -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <!-- Ventas de Hoy + Entradas/Salidas (ocupa 1/3 del ancho) -->
        <section class="md:col-span-1 bg-white rounded-xl shadow p-5 space-y-4">
          <header class="flex justify-between items-center">
            <div class="flex items-center gap-3">
              <div class="bg-green-100 text-green-600 rounded-full p-2">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M12 8c1.657 0 3 1.343 3 3..." />
                </svg>
              </div>
              <h2 class="text-lg font-bold text-gray-900">Ventas de Hoy</h2>
            </div>
            <p class="text-2xl font-extrabold text-green-600">
              S/. {{ number_format($totalSalesToday, 2) }}
            </p>
          </header>

          <div class="space-y-4">
            <!-- Entradas -->
            <div>
              <h3 class="flex items-center gap-2 text-green-700 font-semibold mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M12 4v16m8-8H4" />
                </svg>
                Entradas: {{ $entriesToday }}
              </h3>
              @if($entryProductsToday->count())
                <ul class="bg-green-50 border rounded-md p-3 max-h-40 overflow-y-auto space-y-2 text-sm">
                  @foreach($entryProductsToday as $entrada)
                    <li class="flex justify-between">
                      <span class="truncate">{{ $entrada->product->name ?? 'Producto eliminado' }}</span>
                      <span>{{ $entrada->cantidad }} unid.</span>
                    </li>
                  @endforeach
                </ul>
              @else
                <p class="text-sm text-gray-500">No hay entradas registradas hoy.</p>
              @endif
            </div>

            <!-- Salidas -->
            <div>
              <h3 class="flex items-center gap-2 text-red-700 font-semibold mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M20 12H4" />
                </svg>
                Salidas: {{ $exitsToday }}
              </h3>
              @if($exitProductsToday->count())
                <ul class="bg-red-50 border rounded-md p-3 max-h-40 overflow-y-auto space-y-2 text-sm">
                  @foreach($exitProductsToday as $salida)
                    <li class="flex justify-between">
                      <span class="truncate">{{ $salida->product->name ?? 'Producto eliminado' }}</span>
                      <span>{{ $salida->cantidad }} unid.</span>
                    </li>
                  @endforeach
                </ul>
              @else
                <p class="text-sm text-gray-500">No hay salidas registradas hoy.</p>
              @endif
            </div>
          </div>
        </section>

        <!-- Stock Bajo + Productos por Vencer (ocupan 2/3 del ancho) -->
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
          
          <!-- Stock Bajo -->
          <section class="bg-white rounded-xl shadow p-5 space-y-4 flex flex-col">
            <header class="flex justify-between items-center">
              <div class="flex items-center gap-3">
                <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4m0 4h.01M4.93 19a10 10 0 1114.14 0L12 22l-7.07-3z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Stock Bajo</h2>
              </div>
              <a href="{{ route('entradas') }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white w-10 h-10 rounded-full flex items-center justify-center text-xl font-bold shadow-md"
                title="Agregar stock">+</a>
            </header>

            @if($lowStockProducts > 0)
              <ul class="bg-yellow-50 border border-yellow-300 rounded-md p-3 space-y-2 max-h-56 overflow-y-auto">
                @foreach(\App\Models\Product::whereColumn('current_stock', '<=', 'minimum_stock')->get() as $product)
                  <li class="flex justify-between items-center text-sm bg-yellow-100 px-3 py-2 rounded hover:bg-yellow-200">
                    <span class="truncate font-medium text-yellow-800">{{ $product->name }}</span>
                    <span class="bg-yellow-200 px-2 py-1 rounded-full text-yellow-900 text-xs">
                      {{ $product->current_stock }} unid.
                    </span>
                  </li>
                @endforeach
              </ul>
            @else
              <p class="text-sm text-gray-500 italic text-center">Todos los productos tienen suficiente stock.</p>
            @endif
          </section>

          <!-- Productos por Vencer -->
          <section class="bg-white rounded-xl shadow p-5 space-y-4 flex flex-col">
            <header class="flex justify-between items-center">
              <div class="flex items-center gap-3">
                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4m0 4h.01M4.93 19a10 10 0 1114.14 0L12 22l-7.07-3z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Productos por Vencer</h2>
              </div>
            </header>

            @if($expiringProducts->count())
              <ul class="bg-red-50 border border-red-300 rounded-md p-3 space-y-2 max-h-56 overflow-y-auto">
                @foreach($expiringProducts as $entrada)
                  <li class="flex justify-between items-center text-sm bg-red-100 px-3 py-2 rounded hover:bg-red-200">
                    <span class="truncate font-medium text-red-800">
                      {{ $entrada->product->name ?? 'Producto eliminado' }}
                    </span>
                    <span class="text-red-900 text-xs">
                      Vence: {{ \Carbon\Carbon::parse($entrada->expiration_date)->format('d/m/Y') }}
                    </span>
                  </li>
                @endforeach
              </ul>
            @else
              <p class="text-sm text-gray-500 italic text-center">No hay productos próximos a vencer.</p>
            @endif
          </section>

        </div>
      </div>

    <!-- Fila 2: productos mas vendidos y ventas del mes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Productos Más Vendidos -->
        <section class="bg-white rounded-2xl shadow p-6 max-w-7xl mx-auto" style="width: 100%; height: 400px;">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Productos más vendidos del Año</h2>
            <canvas id="topSellingChart" class="w-full h-full"></canvas>
        </section>

        @php
            $validTopSelling = $topSellingProducts->filter(function($detalle) {
                return $detalle->product && $detalle->product->name;
            });
        @endphp

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('topSellingChart').getContext('2d');

                const rawLabels = [
                    @foreach($validTopSelling as $detalle)
                        "{{ addslashes($detalle->product->name) }}",
                    @endforeach
                ];

                const dataValues = [
                    @foreach($validTopSelling as $detalle)
                        {{ $detalle->total_vendido }},
                    @endforeach
                ];

                function truncateLabel(label, maxLength = 15) {
                    return label.length > maxLength ? label.slice(0, maxLength - 3) + '…' : label;
                }

                const labels = rawLabels.map(label => truncateLabel(label));

                // Colores pastel para las barras
                function getRandomColor(index) {
                    const colors = [
                        '#6366F1', '#EC4899', '#F59E0B', '#10B981', '#3B82F6',
                        '#EF4444', '#8B5CF6', '#22D3EE', '#F97316', '#14B8A6'
                    ];
                    return colors[index % colors.length];
                }

                const backgroundColors = labels.map((_, i) => getRandomColor(i));

                console.log("Labels:", labels);
                console.log("Data:", dataValues);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Unidades vendidas',
                            data: dataValues,
                            backgroundColor: backgroundColors,
                            borderColor: backgroundColors,
                            borderWidth: 1,
                            borderRadius: 0,
                            barPercentage: 0.8,
                            categoryPercentage: 0.7,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: { top: 20, bottom: 30, left: 15, right: 15 }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    font: { size: 14 }
                                },
                                title: {
                                    display: true,
                                    text: 'Unidades vendidas',
                                    font: { size: 16, weight: 'bold' }
                                }
                            },
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 30,
                                    font: { size: 12 }
                                },
                                title: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        return rawLabels[context[0].dataIndex];
                                    },
                                    label: function(context) {
                                        return context.parsed.y + ' unid.';
                                    }
                                },
                                bodyFont: { size: 14 },
                                titleFont: { size: 16, weight: 'bold' }
                            }
                        }
                    }
                });
            });
        </script>
        @endpush

      <!-- Gráfico Ventas por Mes -->
      <section class="bg-white rounded-2xl shadow p-6" style="width: 100%; height: 400px;">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ventas por Mes</h2>
        <canvas id="ventasPorMesChart" width="400" height="200"></canvas>
      </section>
      @push('scripts')
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctx = document.getElementById('ventasPorMesChart').getContext('2d');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($ventasPorMesLabels),
                            datasets: [{
                                label: 'Ventas',
                                data: @json($ventasPorMesData),
                                backgroundColor: '#6366F1',
                                borderColor: '#4338CA',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
      @endpush
    </div>

    
<!-- Evolución de ventas (últimos 7 días) -->
<section class="bg-white rounded-xl shadow p-5 mt-6 w-full">
  <h2 class="text-lg font-semibold text-gray-900 mb-4">Evolución de Ventas (últimos 7 días)</h2>
  <div class="h-[300px]">
    <canvas id="evolucionVentasChart" class="w-full h-full"></canvas>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('evolucionVentasChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($dailySalesLabels),
        datasets: [{
          label: 'Total de Ventas',
          data: @json($dailySalesData),
          backgroundColor: 'rgba(74, 222, 128, 0.3)',
          borderColor: '#4ade80',
          borderWidth: 2,
          fill: true,
          tension: 0.3,
          pointRadius: 4,
          pointBackgroundColor: '#4ade80'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  });
</script>
@endpush

<!-- Ventas por Categoría, Clientes frecuentes, Productos por Proveedor -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">

  <!-- Ventas por Categoría -->
  <section class="bg-white rounded-xl shadow p-5 h-[520px]">
    <h2 class="text-lg font-semibold text-gray-900 text-center mb-4">Ventas por Categoría</h2>
    <div class="w-full h-[460px]">
      <canvas id="ventasPorCategoriaChart" class="w-full h-full"></canvas>
    </div>
  </section>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('ventasPorCategoriaChart').getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: @json($categoryLabels),
          datasets: [{
            label: 'Ventas por Categoría',
            data: @json($categoryTotals),
            backgroundColor: ['#6366F1', '#4ADE80', '#F59E0B', '#EF4444', '#10B981', '#8B5CF6', '#F43F5E', '#22D3EE'],
            borderColor: '#fff',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: { font: { size: 14 }, boxWidth: 14 }
            },
            tooltip: {
              callbacks: {
                label: function (item) {
                  return `${item.label}: S/. ${item.raw.toFixed(2)}`;
                }
              }
            }
          }
        }
      });
    });
  </script>
  @endpush

  <!-- Clientes más frecuentes -->
  <section class="bg-white rounded-xl shadow p-5 h-[520px] overflow-y-auto">
    <h2 class="text-lg font-semibold text-gray-900 text-center mb-4 border-b pb-2">Clientes Más Frecuentes</h2>
    @if($topCustomers->isNotEmpty())
      <ul class="divide-y divide-gray-200">
        @foreach($topCustomers as $customer)
          <li class="py-3 px-2 flex justify-between items-center hover:bg-indigo-50 rounded transition">
            <div>
              <p class="font-medium text-gray-800 truncate">{{ $customer->name }} {{ $customer->lastname }}</p>
              <p class="text-sm text-indigo-600">Cliente frecuente</p>
            </div>
            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 text-sm rounded-full">{{ $customer->ventas_count }} compras</span>
          </li>
        @endforeach
      </ul>
    @else
      <p class="text-gray-500 italic text-center py-12">No hay clientes frecuentes aún.</p>
    @endif
  </section>

  <!-- Productos por Proveedor -->
  <section class="bg-white rounded-xl shadow p-5 h-[520px]">
    <h2 class="text-lg font-semibold text-gray-900 text-center mb-4">Productos por Proveedor</h2>
    <div class="w-full h-[460px]">
      <canvas id="supplierChart" class="w-full h-full"></canvas>
    </div>
  </section>
</div>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('supplierChart').getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: @json($supplierLabels),
          datasets: [{
            label: 'Productos por Proveedor',
            data: @json($supplierCounts),
            backgroundColor: ['#6366F1', '#4ADE80', '#F59E0B', '#EF4444', '#10B981', '#8B5CF6', '#F43F5E', '#22D3EE'],
            borderColor: '#fff',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: { font: { size: 14 }, boxWidth: 14 }
            },
            tooltip: {
              callbacks: {
                label: function (context) {
                  return context.label + ': ' + context.raw + ' productos';
                }
              }
            }
          }
        }
      });
    });
  </script>
  @endpush

</div>


  <!-- Scripts Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  {!! $salesChart->script() !!}
 
</div>
