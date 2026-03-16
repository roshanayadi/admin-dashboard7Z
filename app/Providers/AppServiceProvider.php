<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\App\Services\SmsService::class);
        $this->app->singleton(\App\Services\EmailService::class);
    }

    public function boot(): void
    {
        URL::forceRootUrl(config('app.url'));
        if (str_starts_with(config('app.url'), 'https')) {
            URL::forceScheme('https');
        }
    }
}
