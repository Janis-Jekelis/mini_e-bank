<?php

use App\Http\Controllers\DebitAccountController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/',[UserAccountController::class,'index']);
Route::resource('/home',UserController::class);
Route::resource('/home/{}/',DebitAccountController::class);
