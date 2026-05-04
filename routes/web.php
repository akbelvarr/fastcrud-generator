<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneratorController;

// The single page route
Route::get('/', [GeneratorController::class, 'index'])->name('generator.index');
Route::post('/generator', [GeneratorController::class, 'generate'])->name('generator.process');
Route::get('/download-zip/{fileName}', [GeneratorController::class, 'download'])->name('generator.download');