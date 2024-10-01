<?php

namespace GavreanSean\PackageGenerator;

use Illuminate\Support\ServiceProvider;

class PackageGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/package-generator.php', 'package-generator');

        // Register the main class to use with the facade
        $this->app->singleton('package-generator', function () {
            return $this->app->make(PackageGenerator::class);
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
            Console\DatabaseInstallCommand::class,
            Console\InstallCommand::class,
            Console\LangInstallCommand::class,
            Console\OptimizeConfigurationCommand::class,
            Console\PackageGeneratorCommand::class,
            Console\ResourcesInstallCommand::class,
            Console\RoutesInstallCommand::class,
            Console\StubsInstallCommand::class,
        ]);
    }
}
