<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\RecipientDashboardController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Public landing page
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        } elseif (auth()->user()->role === 'recipient') {
            return redirect()->route('recipient.dashboard');
        } elseif (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }
    return view('welcome');
})->name('home');

// Default dashboard
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        }
        if (auth()->user()->role === 'recipient') {
            return redirect()->route('recipient.dashboard');
        }
         if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');


// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Vendor specific routes
Route::middleware(['auth', 'verified', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('food-items', FoodItemController::class)->except(['show']);
    Route::patch('food-items/{food_item}/status', [FoodItemController::class, 'updateStatus'])->name('food-items.updateStatus');
    Route::get('/recipients/{recipient}', [VendorDashboardController::class, 'showRecipientProfile'])->name('recipient.profile');
});

// Recipient specific routes
Route::middleware(['auth', 'verified', 'role:recipient'])->prefix('recipient')->name('recipient.')->group(function () {
    Route::get('/dashboard', [RecipientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/food-items/{food_item}', [FoodItemController::class, 'showRecipientView'])->name('food-items.show');
    Route::post('/food-items/{food_item}/claim', [FoodItemController::class, 'claim'])->name('food-items.claim');
    Route::get('/my-claims', [RecipientDashboardController::class, 'myClaims'])->name('my-claims');
});

// Admin specific routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'manageUsers'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('users.edit');
    Route::get('/users/{user}/profile', [AdminDashboardController::class, 'showUserProfile'])->name('users.profile'); // New route
    Route::patch('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/food-items', [AdminDashboardController::class, 'manageFoodItems'])->name('food-items.index');
    Route::delete('/food-items/{food_item}', [AdminDashboardController::class, 'destroyFoodItem'])->name('food-items.destroy');
});


require __DIR__.'/auth.php';
