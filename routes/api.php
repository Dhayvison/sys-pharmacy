<?php

use App\Http\Controllers\API\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/categories/suggest-description', [CategoryController::class, 'suggestDescription'])->name('categories.suggest-description');
});
