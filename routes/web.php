<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\DashboardController;

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function(){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('eleve', EleveController::class);
    
    Route::resource('client', ClientController::class);
    
    Route::resource('matiere', MatiereController::class);
    
    Route::resource('cours', CoursController::class);
    
    Route::resource('facture', FactureController::class);
});


