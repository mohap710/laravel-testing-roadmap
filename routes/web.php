<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource("post", PostController::class);

Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
