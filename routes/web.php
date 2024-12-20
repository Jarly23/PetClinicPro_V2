<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\Admin\UserController;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use App\Http\Controllers\Admin\RoleController;
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
    return view('pages.web.home');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/clientes', function () {
        return view('pages.dashboard.customers');
    })->name('customers');
    Route::get('/servicios', function () {
        return view('pages.dashboard.services');
    })->name('services');

    Route::get('/mascotas', function () {
        return view('pages.dashboard.pets');
    })->name('pets');

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


    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/dashboard/fintech', [DashboardController::class, 'fintech'])->name('fintech');
});
Route::get('/pets/{pet}/history', [PetController::class, 'history'])->name('pets.history');

Route::resource('users', UserController::class)->middleware('can:users.index') ->names('admin.users');
Route::resource('roles', RoleController::class)->middleware('can:roles.index')-> names('admin.roles');