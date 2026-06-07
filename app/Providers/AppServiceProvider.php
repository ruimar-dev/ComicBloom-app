<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $cacert = storage_path('cacert.pem');

        if (file_exists($cacert)) {
            Http::globalOptions(['verify' => $cacert]);
        }
    }
}
