<?php

namespace App\Providers;

use App\Rules\Ssand;
use App\Services\GeocodingInterface;
use App\Services\HereGeocoding;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(GeocodingInterface::class, HereGeocoding::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Validator::extend("ssand", function ($attribute, $value, $parameters, $validator) {
            return (new Ssand())->isValid($value);
        });
    }
}
