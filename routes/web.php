<?php

use App\Actions\Dev\RLC\Generate20222024;
use App\Actions\Dev\RLC\Generate20252027;
use App\Actions\Image\GenerateImage;
use App\Actions\RLC\SearchRLC;
use App\Http\Middleware\IsLocalMiddleware;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home/home', [
        'local' => config('app.env') === 'local' ? true : false,
        'posts' => Post::orderBy('created_at', 'DESC')->take(6)->get(),
    ]);
});

Route::prefix('image')->group(function () {
    Route::get('/', function () {
        return Inertia::render('image/image', [
            'base64' => session()->get('base64'),
        ]);
    });
    Route::post('/', GenerateImage::class);
});

Route::prefix('/rlc')->group(function () {
    Route::get('/', function () {
        return Inertia::render('rlc/rlc', [
            'matches' => session()->get('matches') ?? [],
            'years' => [
                '2022', '2023', '2024', '2025',
            ],
        ]);
    });
    Route::post('/', SearchRLC::class);
});

Route::middleware([IsLocalMiddleware::class])->prefix('/dev')->group(function () {
    Route::get('/', function () {
        return Inertia::render('dev/dev', [
            'updates' => json_decode(Storage::get('/dev/updates.json'), true),
        ]);
    });
    Route::post('/generate-2022-2024', Generate20222024::class);
    Route::post('/generate-2025-2027', Generate20252027::class);
});
