<?php

namespace App\Providers;

use Inertia\Inertia;
use App\Models\Currency;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Inertia::share([
            'currency' => function () {
                if (auth()->check()) {
                    return Currency::find(1);
                }
                return '0';
            },
        ]);
    }
}
