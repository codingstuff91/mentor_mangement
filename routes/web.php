<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;


require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function(){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('student', StudentController::class);

    Route::resource('customer', CustomerController::class);

    Route::resource('matiere', MatiereController::class);

    Route::resource('course', CourseController::class);

    Route::resource('facture', FactureController::class);
});


