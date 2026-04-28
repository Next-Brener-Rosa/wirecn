<?php

declare(strict_types=1);

namespace Livecn\Laravel;

use Illuminate\Support\ServiceProvider;

final class LaravelLivecnServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../resources/stubs/views/components/livecn' => resource_path('views/components/livecn'),
        ], 'livecn-views');

        $this->publishes([
            __DIR__.'/../resources/stubs/js' => resource_path('js/livecn'),
        ], 'livecn-js');
    }
}
