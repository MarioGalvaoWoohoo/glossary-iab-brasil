<?php

use App\Http\Controllers\Api\{
    UserController,
    GlossaryController
};

use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class);

Route::prefix('/v1')->group(function () {

    Route::get('/search', [GlossaryController::class, 'search'])->name('glossary.search');

});
