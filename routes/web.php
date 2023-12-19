<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/',[UserAccountController::class,'index']);
Route::resource('/',UserController::class);
