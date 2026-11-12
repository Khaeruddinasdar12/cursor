<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/pengumuman', [PostController::class, 'index'])->name('posts.index');
Route::get('/pengumuman/{post:slug}', [PostController::class, 'show'])->name('posts.show');
