<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RSSController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{section}', [RSSController::class, 'generateRSS'])
    ->middleware('validate.section')
    ->where('section', '[a-z-]+');
