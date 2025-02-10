<?php

    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\Web\WebController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', [WebController::class, 'index'])->name('home');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/admin/{any?}', function () {
            return view('admin.index');
        })->where('any', '.*')->name('admin.dashboard');

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });


    Route::middleware('guest')->group(function () {
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    });


    Route::get('/{cafe:username}', [WebController::class, 'show'])->name('cafe.show');
    Route::get('/{cafe:username}/{category:slug}', [WebController::class, 'categoryShow'])->name('category.show');

    Route::get('/{cafe:username}/{category:slug}/{product:slug}', [WebController::class, 'productShow'])->name('product.show');


