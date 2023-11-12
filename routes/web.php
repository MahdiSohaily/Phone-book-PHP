<?php

use App\Controllers\ContactController;
use App\Core\Routing\Route;


Route::get('/', ['HomeController', 'index']);
Route::get('/contact/add', [ContactController::class, 'add']);
