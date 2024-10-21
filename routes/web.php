<?php

use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'login']);

Route::get('/expert', [ExpertController::class, 'index'])->name('expert.form');
Route::post('/expert', [ExpertController::class, 'create'])->name('expert.create');

Route::get('/', [ChoiceController::class, 'index'])->name('choice.form');
Route::post('/', [ChoiceController::class, 'create'])->name('choice.create');
Route::get('/choices/show/{choice}', [ChoiceController::class, 'show'])->name('choice.show');
Route::get('/choices/edit/{choice}', [ChoiceController::class, 'edit'])->name('choice.edit');
Route::post('/choices/update/{choice}', [ChoiceController::class, 'update'])->name('choice.update');

Route::get('/deposit', [DepositController::class, 'index'])->name('deposit');

//Route::get('choices', [ChoiceController::class, 'index']);

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
