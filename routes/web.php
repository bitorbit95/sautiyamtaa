<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;

// Locale switching route
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

// Public routes - REPLACE the default welcome route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/programs', [ProgramController::class, 'index'])->name('programs');
Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');
Route::get('/donate', [DonationController::class, 'index'])->name('donate');
Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');

// Simple routes for pages without controllers yet
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/impact', function () {
    return view('impact');
})->name('impact');

Route::get('/stories', function () {
    return view('stories');
})->name('stories');

// Dashboard routes (require authentication)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Only include auth routes if the file exists
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}