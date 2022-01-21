<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\MatiereController;

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function(){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::resource('eleve', EleveController::class);
    
    Route::resource('client', ClientController::class);
    
    Route::resource('matiere', MatiereController::class);
    
    Route::resource('cours', CoursController::class);
    
    Route::resource('facture', FactureController::class);
});


