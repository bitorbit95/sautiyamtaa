<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Localization Routes
|--------------------------------------------------------------------------
|
| Routes for handling language switching between English and Swahili
|
*/

Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| These routes are accessible to all visitors without authentication
|
*/

// Main pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
// stories
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/{story:slug}', [StoryController::class, 'show'])->name('stories.show');

// Programs
Route::get('/programs', [ProgramController::class, 'index'])->name('programs');
Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Blog routes
Route::prefix('blogs')->name('blogs.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/search', [BlogController::class, 'search'])->name('search');
    Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('tag');
    Route::get('/{post:slug}', [BlogController::class, 'show'])->name('show');
});

// Donation routes
Route::prefix('donate')->name('donate.')->group(function () {
    Route::get('/', [DonationController::class, 'index'])->name('index');
    Route::post('/', [DonationController::class, 'store'])->name('store');
    Route::get('status/{transactionId}', [DonationController::class, 'status'])->name('status');
    Route::get('manual/{transactionId}', [DonationController::class, 'manual'])->name('manual');
    Route::get('success/{transactionId}', [DonationController::class, 'success'])->name('success');
    Route::get('check-status/{transactionId}', [DonationController::class, 'checkStatus'])->name('check-status');
    Route::post('resend-stk/{transactionId}', [DonationController::class, 'resendSTK'])->name('resend-stk');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
|
| Routes that require user authentication
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // User profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes that require authentication and admin role
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Contact management
    Route::get('/contacts', [ContactController::class, 'admin'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.update-status');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    
    // Program management
    Route::resource('programs', ProgramController::class)->except(['show']);
    Route::patch('/programs/{program}/toggle-featured', [ProgramController::class, 'toggleFeatured'])->name('programs.toggle-featured');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Include Laravel's default authentication routes if available
|
*/



if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}