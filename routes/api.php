<?php

    use App\Http\Controllers\Api\CategoryController;
    use App\Http\Controllers\Api\ProductController;
    use App\Http\Controllers\Api\UserController;
    use Illuminate\Support\Facades\Route;

//    Route::get('/test', function () {
//        return response()->json([
//            'message' => 'Api Çalışıyor'
//        ]);
//    });

    Route::apiResource('/users', UserController::class);

    Route::apiResource('/categories', CategoryController::class);

    Route::get('/categories/{category}/products', [ProductController::class, 'productsByCategory']);

    Route::apiResource('/products', ProductController::class)->except(['index', 'show']);

