<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generator', [GeneratorController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/export-zip/{modelName}', [ExportController::class, 'downloadZip']);
Route::post('/generator', [GeneratorController::class, 'generate'])->name('generator.process');
Route::resource('categories', App\Http\Controllers\CategoryController::class);
Route::resource('orders', App\Http\Controllers\OrderController::class);
Route::resource('handphones', App\Http\Controllers\HandphoneController::class);
Route::resource('handphones', App\Http\Controllers\HandphoneController::class);
Route::resource('laptops', App\Http\Controllers\LaptopController::class);
Route::resource('laptops', App\Http\Controllers\LaptopController::class);
Route::resource('phones', App\Http\Controllers\PhoneController::class);
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('galons', App\Http\Controllers\GalonController::class);
Route::resource('games', App\Http\Controllers\GameController::class);
Route::resource('events', App\Http\Controllers\EventController::class);
Route::resource('events', App\Http\Controllers\EventController::class);
Route::resource('events', App\Http\Controllers\EventController::class);
Route::resource('events', App\Http\Controllers\EventController::class);
Route::resource('tasks', App\Http\Controllers\TaskController::class);
Route::resource('members', App\Http\Controllers\MemberController::class);
Route::resource('houses', App\Http\Controllers\HouseController::class);
Route::resource('houses', App\Http\Controllers\HouseController::class);
Route::resource('kosts', App\Http\Controllers\KostController::class);
Route::resource('bakeries', App\Http\Controllers\BakeryController::class);
Route::resource('bakeries', App\Http\Controllers\BakeryController::class);
Route::resource('bakeries', App\Http\Controllers\BakeryController::class);
Route::resource('coffees', App\Http\Controllers\CoffeeController::class);
Route::resource('cafes', App\Http\Controllers\CafeController::class);