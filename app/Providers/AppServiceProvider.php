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
        \App\Models\Apprentice::observe(\App\Observers\ApprenticeObserver::class);
        \App\Models\Teacher::observe(\App\Observers\TeacherObserver::class);
        \App\Models\Group::observe(\App\Observers\GroupObserver::class);
        \App\Models\Service::observe(\App\Observers\ServiceObserver::class);
        \App\Models\Pago::observe(\App\Observers\PagoObserver::class);
        \App\Models\Informe::observe(\App\Observers\InformeObserver::class);
        \App\Models\SecurityInforme::observe(\App\Observers\SecurityInformeObserver::class);
    }
}
