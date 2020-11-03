<?php

namespace ArtARTs36\EventStat\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;

class EventStatProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->registerEloquentFactories();
        }
    }

    protected function registerEloquentFactories(): void
    {
        $this->app->make(EloquentFactory::class)->load(__DIR__ . '/../../database/factories');
    }
}
