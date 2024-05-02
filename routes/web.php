<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; //add the ControllerNameSpace

Route::get('/', function () {
    return view('welcome');
});

Route::resource("/employees", EmployeeController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
