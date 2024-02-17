<?php

use Inertia\Inertia;
use App\Actions\GenerateImage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return Inertia::render('index'); });
Route::get('/image', function () { return Inertia::render('image', [
    'base64' => session()->get('base64'),
]); });
Route::post('/image', GenerateImage::class);
