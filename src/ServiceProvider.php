<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected bool $defer = true;

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/evidence.php',
            'esign'
        );

        $config = config('evidence');

        $this->app->bind(Evidence::class, static function () use ($config) {
            return new Evidence($config['app_id'] ?? null, $config['secret'] ?? null, $config['evidence_server'] ?? null, $config['esign_server'] ?? null);
        });

        $this->app->alias(Evidence::class, 'evidence');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/evidence.php' => config_path('evidence.php'),
        ], 'config');
    }
}
