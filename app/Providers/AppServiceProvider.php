<?php

namespace App\Providers;

use App\Models\PublicPageSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        try {
            if (Schema::hasTable('public_page_settings')) {
                $publicContent = PublicPageSetting::getContent();
            } else {
                $publicContent = PublicPageSetting::defaults();
            }
        } catch (\Throwable $e) {
            $publicContent = PublicPageSetting::defaults();
        }
        View::share('publicContent', $publicContent);
        View::share('publicOthers', $publicContent['others'] ?? PublicPageSetting::othersDefaults());
    }
}
