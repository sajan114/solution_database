<?php

use App\Http\Controllers\ProblemController;
use App\Models\Solution;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProblemController::class, 'index']);
Route::resource('problems', ProblemController::class);

Route::get('/solutions/{solution}', function (Solution $solution) {
    return view('solution', ['solution' => $solution]);
});