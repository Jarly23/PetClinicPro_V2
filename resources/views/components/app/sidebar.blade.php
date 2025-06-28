<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex lg:!flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-sm' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('dashboard') }}">
                <svg class="fill-violet-500" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                    <path
                        d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                </svg>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">
                    <!-- Dashboard -->
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['dashboard', 'analytics'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }} @endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['dashboard', 'analytics']) ? 1 : 0 }} }">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['dashboard', 'analytics'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['dashboard', 'analytics'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M5.936.278A7.983 7.983 0 0 1 8 0a8 8 0 1 1-8 8c0-.722.104-1.413.278-2.064a1 1 0 1 1 1.932.516A5.99 5.99 0 0 0 2 8a6 6 0 1 0 6-6c-.53 0-1.045.076-1.548.21A1 1 0 1 1 5.936.278Z" />
                                        <path
                                            d="M6.068 7.482A2.003 2.003 0 0 0 8 10a2 2 0 1 0-.518-3.932L3.707 2.293a1 1 0 0 0-1.414 1.414l3.775 3.775Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500 @if (in_array(Request::segment(1), ['dashboard', 'analytics'])) {{ 'rotate-180' }} @endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-8 mt-1 @if (!in_array(Request::segment(1), ['dashboard', 'analytics'])) {{ 'hidden' }} @endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('dashboard')) {{ '!text-violet-500' }} @endif"
                                        href="{{ route('dashboard') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Gestión Comercial</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('analytics')) {{ '!text-violet-500' }} @endif"
                                        href="{{ route('analytics') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Panel de Inventario</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('fintech')) {{ '!text-violet-500' }} @endif"
                                        href="{{ route('egresos') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Panel de Egresos</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Customers -->
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['clientes'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }} @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['clientes'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="{{ route('customers') }}">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16"
                                    height="16">
                                    <path fill="#9ca3af"
                                        d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z" />
                                </svg>

                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 @if (Route::is('customers')) {{ '!text-violet-500' }} @endif">Clientes</span>
                            </div>
                        </a>
                    </li>
                    <!-- Pets -->
                    @can('mascotas.index')
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['mascotas'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04] ' }} @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['mascotas'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="{{ route('pets') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['mascotas'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16"
                                    height="16">
                                    <path fill="#9ca3af"
                                        d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5l0 1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3l0-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" />
                                </svg>

                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200  @if (Route::is('pets')) {{ '!text-violet-500' }} @endif">Mascotas</span>
                            </div>
                        </a>
                    </li>
                    @endcan

                    <!-- reservations -->
                    @can('reservas.index')
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['reservas'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }} @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['reservas'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="{{ route('reservations') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['reservas'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16">
                                    <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                                    <path
                                        d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 @if (Route::is('reservations')) {{ '!text-violet-500' }} @endif">Reservaciones</span>
                            </div>
                        </a>
                    </li>
                    @endcan

                    <!-- consultation -->
                    @can('consultas.index')
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['consultas'])) from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04] @endif">
                        <a href="{{ route('consultations') }}"
                            class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['consultas'])) hover:text-gray-900 dark:hover:text-white @endif">
                            <div class="flex items-center">
                                <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['consultas'])) {{ 'text-violet-500' }} @else {{ 'text-gray-400 dark:text-gray-500' }} @endif"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16">
                                    <path fill="currentColor"
                                        d="M142.4 21.9c5.6 16.8-3.5 34.9-20.2 40.5L96 71.1 96 192c0 53 43 96 96 96s96-43 96-96l0-120.9-26.1-8.7c-16.8-5.6-25.8-23.7-20.2-40.5s23.7-25.8 40.5-20.2l26.1 8.7C334.4 19.1 352 43.5 352 71.1L352 192c0 77.2-54.6 141.6-127.3 156.7C231 404.6 278.4 448 336 448c61.9 0 112-50.1 112-112l0-70.7c-28.3-12.3-48-40.5-48-73.3c0-44.2 35.8-80 80-80s80 35.8 80 80c0 32.8-19.7 61-48 73.3l0 70.7c0 97.2-78.8 176-176 176c-92.9 0-168.9-71.9-175.5-163.1C87.2 334.2 32 269.6 32 192L32 71.1c0-27.5 17.6-52 43.8-60.7l26.1-8.7c16.8-5.6 34.9 3.5 40.5 20.2zM480 224a32 32 0 1 0 0-64 32 32 0 1 0 0 64z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 @if (Route::is('consultations')) !text-violet-500 @endif">
                                    Consultas
                                </span>
                            </div>
                        </a>
                    </li>
                    @endcan
                    <!-- reportes -->
                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['reportes'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }} @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['reportes'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="{{ route('report') }}">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16">
                                    <path fill="#9ca3af"
                                        d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM80 64l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L80 96c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-64 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96l192 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32L96 352c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32zm0 32l0 64 192 0 0-64L96 256zM240 416l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-64 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 @if (Route::is('report')) !text-violet-500 @endif">Reportes</span>
                            </div>
                        </a>
                    </li>
                    @php
                        $gestionRoutes = ['inventary', 'suppliers', 'products'];
                        $isGestionRoute = in_array(Request::segment(1), $gestionRoutes);
                    @endphp

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0
                        bg-[linear-gradient(135deg,var(--tw-gradient-stops))]
                        @if ($isGestionRoute) from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04] @endif"
                        x-data="{ open: {{ $isGestionRoute ? 'true' : 'false' }} }">

                        <a class="block text-gray-800 dark:text-gray-100 truncate transition
                            @if (!$isGestionRoute) hover:text-gray-900 dark:hover:text-white @endif"
                            href="#0"
                            @click.prevent="
                                if (!{{ $isGestionRoute ? 'true' : 'false' }}) {
                                    open = !open;
                                    sidebarExpanded = true;
                                }
                            ">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current
                                            @if ($isGestionRoute) text-violet-500
                                            @else
                                                text-gray-400 dark:text-gray-500 @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M10.5 1a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2h-1.145a3.502 3.502 0 0 1-6.71 0H1a1 1 0 0 1 0-2h6.145A3.502 3.502 0 0 1 10.5 1ZM9 4.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM5.5 9a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2H8.855a3.502 3.502 0 0 1-6.71 0H1a1 1 0 1 1 0-2h1.145A3.502 3.502 0 0 1 5.5 9ZM4 12.5a1.5 1.5 0 1 0 3 0 1.5 1.5 0 0 0-3 0Z"
                                            fill-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        Gestión de Producto
                                    </span>
                                </div>
                                <!-- Icono flechita -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <!-- Categoria -->
                            <ul class="pl-8 mt-1" :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a href="{{ route('categorias') }}"
                                        class="flex items-center text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate
                                            @if (Route::is('categorias')) !text-violet-500 @endif">
                                        <!-- Icono Categoria (folder) -->
                                        <svg class="w-4 h-4 shrink-0 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Categoria
                                        </span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Proveedor -->
                            <ul class="pl-8 mt-1" :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a href="{{ route('suppliers') }}"
                                        class="flex items-center text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate
                                            @if (Route::is('suppliers')) !text-violet-500 @endif">
                                        <!-- Icono Proveedor (truck) -->
                                        <svg class="w-4 h-4 shrink-0 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 00-8 0v2m4 0h8m-6-6h6l2 4m-6 2v-6m6 8a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Proveedor
                                        </span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Productos -->
                            <ul class="pl-8 mt-1" :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a href="{{ route('products') }}"
                                        class="flex items-center text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate
                                            @if (Route::is('products')) !text-violet-500 @endif">
                                        <!-- Icono Productos (box) -->
                                        <svg class="w-4 h-4 shrink-0 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4v10l-9 4-9-4V7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10l9 4 9-4V7" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v10" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Productos
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @php
                        $gestionRoutes = ['settings'];
                        $isGestionRoute = in_array(Request::segment(1), $gestionRoutes);
                    @endphp

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0
                        bg-[linear-gradient(135deg,var(--tw-gradient-stops))]
                        @if ($isGestionRoute) from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04] @endif"
                        x-data="{ open: {{ $isGestionRoute ? 'true' : 'false' }} }">

                        <a class="block text-gray-800 dark:text-gray-100 truncate transition
                            @if (!$isGestionRoute) hover:text-gray-900 dark:hover:text-white @endif"
                            href="#0"
                            @click.prevent="
                                if (!{{ $isGestionRoute ? 'true' : 'false' }}) {
                                    open = !open;
                                    sidebarExpanded = true;
                                }
                            ">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current
                                        @if ($isGestionRoute) text-violet-500 @else text-gray-400 dark:text-gray-500 @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M10.5 1a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2h-1.145a3.502 3.502 0 0 1-6.71 0H1a1 1 0 0 1 0-2h6.145A3.502 3.502 0 0 1 10.5 1ZM9 4.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM5.5 9a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2H8.855a3.502 3.502 0 0 1-6.71 0H1a1 1 0 1 1 0-2h1.145A3.502 3.502 0 0 1 5.5 9ZM4 12.5a1.5 1.5 0 1 0 3 0 1.5 1.5 0 0 0-3 0Z"
                                            fill-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4
                                        lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        Gestion de existencia
                                    </span>
                                </div>

                                <div
                                    class="flex shrink-0 ml-2
                                    lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>

                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <!-- Entradas -->
                            <ul class="pl-8 mt-1" :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a href="{{ route('entradas') }}"
                                        class="flex items-center text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate
                                        @if (Route::is('entradas')) !text-violet-500 @endif">
                                        <!-- Icono Caja -->
                                        <svg class="w-4 h-4 shrink-0 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16zM12 3.2l6.16 3.54L12 10.27 5.84 6.74 12 3.2z" />
                                            <path d="M12 12v9.55l-6-3.46V13l6 3z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Entradas
                                        </span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Registrar Venta -->
                            <ul class="pl-8 mt-1" :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a href="{{ route('venta') }}"
                                        class="flex items-center text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate
                                        @if (Route::is('venta')) !text-violet-500 @endif">
                                        <!-- Icono Carrito -->
                                        <svg class="w-4 h-4 shrink-0 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                            <circle cx="7" cy="21" r="2" />
                                            <circle cx="17" cy="21" r="2" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Registrar Venta
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            
                            <!-- Historial de ventas -->
                            <ul class="pl-8 mt-1" :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a href="{{ route('historial') }}"
                                        class="flex items-center text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate
                                        @if (Route::is('historial')) !text-violet-500 @endif">
                                        <!-- Icono Reloj -->
                                        <svg class="w-4 h-4 shrink-0 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Historial de ventas
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Notificaciones-->

                    <li
                        class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['documentacion'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }} @endif">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['documentacion'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="{{ route('documentacion') }}">
                            <div class="flex items-center justify-between">
                                <div class="grow flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['documentacion'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M13.95.879a3 3 0 0 0-4.243 0L1.293 9.293a1 1 0 0 0-.274.51l-1 5a1 1 0 0 0 1.177 1.177l5-1a1 1 0 0 0 .511-.273l8.414-8.414a3 3 0 0 0 0-4.242L13.95.879ZM11.12 2.293a1 1 0 0 1 1.414 0l1.172 1.172a1 1 0 0 1 0 1.414l-8.2 8.2-3.232.646.646-3.232 8.2-8.2Z" />
                                        <path d="M10 14a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2h-5Z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Mensajes</span>
                                </div>
                                <!-- Badge -->
                                <div class="flex flex-shrink-0 ml-2">
                                    <span
                                        class="inline-flex items-center justify-center h-5 text-xs font-medium text-white bg-violet-400 px-2 rounded">4</span>
                                </div>
                            </div>
                        </a>
                    </li>

                    <!-- Settings -->
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] @if (in_array(Request::segment(1), ['settings'])) {{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }} @endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['settings']) ? 1 : 0 }} }">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['settings'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(1), ['settings'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M10.5 1a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2h-1.145a3.502 3.502 0 0 1-6.71 0H1a1 1 0 0 1 0-2h6.145A3.502 3.502 0 0 1 10.5 1ZM9 4.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM5.5 9a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2H8.855a3.502 3.502 0 0 1-6.71 0H1a1 1 0 1 1 0-2h1.145A3.502 3.502 0 0 1 5.5 9ZM4 12.5a1.5 1.5 0 1 0 3 0 1.5 1.5 0 0 0-3 0Z"
                                            fill-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Configuración</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500 @if (in_array(Request::segment(1), ['settings'])) {{ 'rotate-180' }} @endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <!--Services-->
                            <ul class="pl-8 mt-1 @if (!in_array(Request::segment(1), ['settings'])) {{ 'hidden' }} @endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('services')) {{ '!text-violet-500' }} @endif"
                                        href="{{ route('services') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Servicios</span>
                                    </a>
                                </li>
                            </ul>
                            <!--Tipos de  animales-->
                            <ul class="pl-8 mt-1 @if (!in_array(Request::segment(1), ['settings'])) {{ 'hidden' }} @endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('animalType')) {{ '!text-violet-500' }} @endif"
                                        href="{{ route('animalType') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Tipo de animales</span>
                                    </a>
                                </li>
                            </ul>

                            <!--Vacunas y enfermedades-->
                            <ul class="pl-8 mt-1 @if (!in_array(Request::segment(1), ['settings'])) {{ 'hidden' }} @endif"
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('vaccines-diseases')) {{ '!text-violet-500' }} @endif"
                                        href="{{ route('vaccines-diseases') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Vacunas y enfermedades</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Users -->
                            @can('users.index')
                                <ul class="pl-8 mt-1 @if (!in_array(Request::segment(1), ['settings'])) {{ 'hidden' }} @endif"
                                    :class="open ? '!block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.users.index')) {{ '!text-violet-500' }} @endif"
                                            href="{{ route('admin.users.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Usuarios</span>
                                        </a>
                                    </li>
                                </ul>
                            @endcan
                            <!-- roles -->
                            @can('roles.index')
                                <ul class="pl-8 mt-1 @if (!in_array(Request::segment(1), ['settings'])) {{ 'hidden' }} @endif"
                                    :class="open ? '!block' : 'hidden'">
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('roles')) {{ '!text-violet-500' }} @endif"
                                            href="{{ route('admin.roles.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Roles</span>
                                        </a>
                                    </li>
                                </ul>
                            @endcan

                        </div>
                    </li>

                </ul>
            </div>
            <!-- More group -->
            @if (Auth::user()->hasRole('Admin'))
                <div>
                    <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                            aria-hidden="true">•••</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">More</span>
                    </h3>
                    <ul class="mt-3">
                        <!-- Authentication -->
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0" x-data="{ open: false }">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                                :class="open ? '' : 'hover:text-gray-900 dark:hover:text-white'" href="#0"
                                @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M11.442 4.576a1 1 0 1 0-1.634-1.152L4.22 11.35 1.773 8.366A1 1 0 1 0 .227 9.634l3.281 4a1 1 0 0 0 1.59-.058l6.344-9ZM15.817 4.576a1 1 0 1 0-1.634-1.152l-5.609 7.957a1 1 0 0 0-1.347 1.453l.656.8a1 1 0 0 0 1.59-.058l6.344-9Z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Autenticación</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="{ 'rotate-180': open }" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="{ 'hidden': !open }" x-cloak>
                                    <li class="mb-1 last:mb-0">
                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf

                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                                href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Iniciar
                                                    sesión</span>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            @endif
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="w-12 pl-4 pr-3 py-2">
                <button
                    class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                    @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 sidebar-expanded:rotate-180"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
