<?php

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('problems', ['problems' => Problem::all()]);
});

Route::get('/problems/{problem}', function (Problem $problem) {
    return view('problem', ['problem' => $problem]);
});

Route::get('/solutions/{solution}', function (Solution $solution) {
    return view('solution', ['solution' => $solution]);
});