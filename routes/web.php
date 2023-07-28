<?php

use Illuminate\Support\Facades\Route;
use Filament\Http\Controllers\FilamentAssetController;
use Filament\Http\Controllers\FilamentController;
use App\Http\Controllers\PHPMailerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get("email", [PHPMailerController::class, "email"])->name("email");

Route::post("send-email", [PHPMailerController::class, "composeEmail"])->name("send-email");


Route::redirect('/', '/admin');




