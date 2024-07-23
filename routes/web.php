<?php

use App\Livewire\Book\View;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});