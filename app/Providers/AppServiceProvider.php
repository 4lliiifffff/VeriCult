<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::policy(\App\Models\CulturalSubmission::class, \App\Policies\CulturalSubmissionPolicy::class);

        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        \Illuminate\Validation\Rules\Password::defaults(function () {
            return \Illuminate\Validation\Rules\Password::min(8)
                ->mixedCase()
                ->numbers();
        });

        \App\Models\User::observe(\App\Observers\UserObserver::class);

        // CMS: Provide global settings to all views
        view()->composer('*', function ($view) {
            $site_global = \Illuminate\Support\Facades\Cache::remember('site_content_global', 3600, function() {
                return \App\Models\SiteContent::getContentForPage('global');
            });
            $view->with('site_global', $site_global);
        });

        // CMS: Provide SEO metadata to specific public pages
        view()->composer(['index', 'tentang', 'fitur', 'profil-kebudayaan.*'], function ($view) {
            $site_seo = \Illuminate\Support\Facades\Cache::remember('site_content_seo', 3600, function() {
                return \App\Models\SiteContent::getContentForPage('seo');
            });
            $view->with('site_seo', $site_seo);
        });
    }
}
