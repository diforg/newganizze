<?php

use App\Http\Controllers\Api\V1\HealthCheckController;
use App\Http\Controllers\Api\V1\MeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function (): void {
        Route::get('/health', HealthCheckController::class)
            ->name('health');

        Route::middleware('auth:sanctum')->group(function (): void {
            Route::get('/me', MeController::class)
                ->name('me');
        });
    });
