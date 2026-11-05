<?php

use App\Http\Controllers\ProblemController;
use App\Http\Controllers\SolutionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProblemController::class, 'index']);
Route::resource('problems', ProblemController::class);

Route::get('/solutions/{solution}', [SolutionController::class, 'show']);
