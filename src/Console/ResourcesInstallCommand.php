<?php

namespace GavreanSean\AssetFiles\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ResourcesInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset-files:resources-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the asset-files resources files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->resources();
    }

    /**
     * Resources.
     */
    protected function resources(): void
    {
        $this->views();

        $this->info('Publishing the resources files completed successfully.');
    }

    /**
     * Views.
     */
    protected function views(): void
    {
        (new Filesystem)->copyDirectory(__DIR__.'/../../resources/views', resource_path('views/asset-files'));
    }
}
