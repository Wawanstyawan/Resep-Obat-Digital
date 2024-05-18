<?php

use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('reseps', ResepController::class);
    Route::get('/resep/{id}/pdf', [ResepController::class, 'generatePdf'])->name('resep.pdf');
    Route::get('/reseps/{resep}/cetak', [ResepController::class, 'cetak'])->name('reseps.cetak');

});
