<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Dashboard::class)->name('dashboard');
Route::get('/users', \App\Livewire\UserList::class)->name('user.list');
