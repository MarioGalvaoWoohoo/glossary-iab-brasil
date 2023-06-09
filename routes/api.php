<?php

use App\Http\Controllers\Api\{
    UserController,
    ExpenseController,
    GlossaryController
};

use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class);
Route::apiResource('/expenses', ExpenseController::class);


Route::prefix('/v1')->group(function () {

    Route::get('/search', [GlossaryController::class, 'search'])->name('glossary.search');

    Route::middleware(['jwt.verify'])->group(function () {
        Route::get('/users', [UserController::class, 'listAll'])->name('users.listAll');

        Route::get('/expenses', [ExpenseController::class, 'listAll'])->name('expenses.listAll');
        Route::post('/expense', [ExpenseController::class, 'store'])->name('expense.store');
        Route::get('/expense/{id}', [ExpenseController::class, 'show'])->name('expense.show');
        Route::put('/expense/{id}', [ExpenseController::class, 'update'])->name('expense.update');
        Route::delete('/expense/{id}', [ExpenseController::class, 'destroy'])->name('expense.destroy');
    });
});
// Route::delete('/users/{email}', [UserController::class, 'destroy']);
// Route::put('/users/{email}', [UserController::class, 'update']);
// Route::get('/users/{email}', [UserController::class, 'show']);
// Route::post('/users', [UserController::class, 'store']);
// Route::get('/users', [UserController::class, 'index']);
