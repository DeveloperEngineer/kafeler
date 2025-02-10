<?php

    use App\Http\Controllers\Api\CategoryController;
    use App\Http\Controllers\Api\ProductController;
    use App\Http\Controllers\Api\UserController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function () {
            return response()->json(Auth::user());
        });
        Route::apiResource('/categories', CategoryController::class);

        Route::get('/categories/{category}/products', [ProductController::class, 'productsByCategory']);

        Route::apiResource('/products', ProductController::class)->except(['show']);

        Route::apiResource('/users', UserController::class);
    });





