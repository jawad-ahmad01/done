<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/new', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $users = User::latest()->paginate(10);
        return view('dashboard', compact('users'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

use App\Http\Controllers\ProductController;

// Product Management Routes
Route::resource('products', ProductController::class);

// Redirect home to products for this demo
Route::get('/', function () {
    return redirect()->route('products.index');
});

require __DIR__.'/auth.php';
