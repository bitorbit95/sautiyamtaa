<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // ✅ Add this line

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('local')) {
            URL::forceRootUrl(config('app.url'));  // Uses your APP_URL
            URL::forceScheme('https');             // Ensures HTTPS
        }
    }
}
