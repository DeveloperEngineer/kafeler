<?php

    use App\Http\Controllers\Web\WebController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', [WebController::class, 'index'])->name('home');

    Route::get('/{cafe:username}', [WebController::class, 'show'])->name('cafe.show');
    Route::get('/{cafe:username}/{category:slug}', [WebController::class, 'categoryShow'])->name('category.show');

    Route::get('/{cafe:username}/{category:slug}/{product:slug}', [WebController::class, 'productShow'])->name('product.show');
