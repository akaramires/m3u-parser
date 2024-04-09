<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Providers;

use Illuminate\Support\ServiceProvider;

class M3uParserServiceProvider extends ServiceProvider
{
    protected bool $defer = false;

    public function boot(): void
    {
        $this->configurePublishing();
    }

    public function configurePublishing(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $source = realpath($raw = __DIR__ . '/../config/m3u-parser.php')
            ?: $raw;

        $this->publishes([$source => $this->app->configPath('m3u-parser.php')]);
    }

    public function register(): void
    {
    }
}
