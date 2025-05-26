<?php

use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\SubsidiaryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('families', FamilyController::class);
Route::resource('subsidiaries', SubsidiaryController::class);