<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\Admin\UserController;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Livewire\CategoryComponent;
use App\Http\Controllers\PDFController;
use App\Livewire\Pets\Detail;
use App\Livewire\Pets\Show;
use App\Livewire\UserCreate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/clientes', function () {
        return view('pages.dashboard.customers');
    })->middleware('can:clientes.index')->name('customers');
    Route::get('/servicios', function () {
        return view('pages.dashboard.services');
    })->name('services');

    Route::get('/mascotas', function () {
        return view('pages.dashboard.pets');
    })->middleware('can:mascotas.index')->name('pets');

    Route::get('/veterinarios', function () {
        return view('pages.dashboard.veterinarians');
    })->name('veterinarians');

    Route::get('/reservas', function () {
        return view('pages.dashboard.reservations');
    })->name('reservations');

    Route::get('/consultas', function () {
        return view('pages.dashboard.consultations');
    })->name('consultations');

    Route::get('/reportes', function () {
        return view('pages.dashboard.reports');
    })->name('report');

    Route::get('/Productos', function () {
        return view('pages.dashboard.categorys');
    })->name('inventary'); //

    Route::get('/proveedor', function () {
        return view('pages.dashboard.suppliers');
    })->name('suppliers'); //

    Route::get('/producto', function () {
        return view('pages.dashboard.products');
    })->name('products'); //

    Route::get('/entradas', function () {
        return view('pages.dashboard.entradas'); // Asegúrate que esta vista exista
    })->name('entradas');

    Route::get('/registrar-venta', function () {
        return view('pages.dashboard.notaventa'); // Asegúrate que esta vista exista
    })->name('venta');

    Route::get('/Historial', function () {
        return view('pages.dashboard.Historial'); // Asegúrate que esta vista exista
    })->name('historial');

    Route::get('/Analityc', function () {
        return view('pages.dashboard.dashboardInve'); // Asegúrate que esta vista exista
    })->name('analytics');


    // Ruta a Documentacion:
    Route::get('/Documentacion', function () {
        return view('pages.dashboard.documentacion');
    })->name('documentacion');

    Route::get('/config-Animal-type', function () {
        return view('pages.dashboard.animalType');
    })->name('animalType');

    Route::get('/config-vacunas-enfermedades', function () {
        return view('pages.dashboard.vaccinesDiseases');
    })->name('vaccines-diseases');

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/fintech', [DashboardController::class, 'fintech'])->name('fintech');

});
Route::get('/pets/{pet}/show', Show::class)->name('pets.detail');

Route::resource('users', UserController::class)->middleware('can:users.index')->names('admin.users');
Route::resource('roles', RoleController::class)->middleware('can:roles.index')->names('admin.roles');


