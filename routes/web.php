<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PortfolioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Database connected successfully!";
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});

// Temporary API routes
Route::prefix('api')->group(function () {
    Route::get('/portfolios', [PortfolioController::class, 'index']);
    Route::get('/portfolios/{slug}', [PortfolioController::class, 'show']);
});