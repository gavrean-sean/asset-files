<?php

namespace GavreanSean\PackageGenerator\Console;

use Illuminate\Console\Command;

class OptimizeConfigurationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize-configuration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deployment optimization configuration';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->optimizeConfiguration();
    }

    /**
     * Optimize configuration.
     */
    protected function optimizeConfiguration(): void
    {
        foreach (configValue('optimization_commands') as $optimizationCommand) {
            $this->call($optimizationCommand);

            unset($optimizationCommand);
        }
    }
}
