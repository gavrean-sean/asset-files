<?php

namespace GavreanSean\AssetFiles;

use Illuminate\Support\ServiceProvider;

class AssetFilesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/asset-files.php', 'asset-files');

        // Register the main class to use with the facade
        $this->app->singleton('asset-files', function () {
            return $this->app->make(AssetFiles::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Registering package commands
        $this->commands([
            Console\AssetsInstallCommand::class,
            Console\ConfigInstallCommand::class,
            Console\InstallCommand::class,
            Console\OptimizeConfigurationCommand::class,
        ]);
    }
}
