<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hola Admin';
})->name('home');