<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\RecipientDashboardController;
use App\Http\Controllers\FoodItemController;
use Illuminate\Support\Facades\Route;

// Public landing page
Route::get('/', function () {
    // If user is logged in, redirect to their respective dashboard
    if (auth()->check()) {
        if (auth()->user()->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        } elseif (auth()->user()->role === 'recipient') {
            return redirect()->route('recipient.dashboard');
        } elseif (auth()->user()->role === 'admin') {
            // Optional: redirect admin to a specific dashboard or default
            return redirect('/dashboard'); // Default Laravel dashboard
        }
    }
    return view('welcome'); // A generic welcome page
})->name('home');

// Default Laravel dashboard route (e.g., for admin or general authenticated users if not vendor/recipient)
Route::get('/dashboard', function () {
    if (auth()->check()) { // Ensure user is authenticated before checking role
        if (auth()->user()->role === 'vendor') {
            return redirect()->route('vendor.dashboard');
        }
        if (auth()->user()->role === 'recipient') {
            return redirect()->route('recipient.dashboard');
        }
        // For admin or other roles, show a generic dashboard or implement their specific one
        return view('dashboard');
    }
    return redirect()->route('login'); // If not authenticated, redirect to login
})->middleware(['auth', 'verified'])->name('dashboard');


// Authenticated user routes (profile management from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Vendor specific routes
Route::middleware(['auth', 'verified', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('food-items', FoodItemController::class)->except(['show']); // Vendors manage their items
    Route::patch('food-items/{food_item}/status', [FoodItemController::class, 'updateStatus'])->name('food-items.updateStatus');
});

// Recipient specific routes
Route::middleware(['auth', 'verified', 'role:recipient'])->prefix('recipient')->name('recipient.')->group(function () {
    Route::get('/dashboard', [RecipientDashboardController::class, 'index'])->name('dashboard'); // Lists available food
    Route::get('/food-items/{food_item}', [FoodItemController::class, 'showRecipientView'])->name('food-items.show');
    Route::post('/food-items/{food_item}/claim', [FoodItemController::class, 'claim'])->name('food-items.claim');
    Route::get('/my-claims', [RecipientDashboardController::class, 'myClaims'])->name('my-claims');
});

require __DIR__.'/auth.php'; // From Laravel Breeze/Jetstream