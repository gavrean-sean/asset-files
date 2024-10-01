<?php

namespace GavreanSean\AssetFiles\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class AssetsInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset-files:assets-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the asset-files assets files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->assets();
    }

    /**
     * Assets.
     */
    protected function assets(): void
    {
        (new Filesystem)->copyDirectory(__DIR__.'/../../assets', public_path('asset-files'));

        $this->info('Publishing the assets files completed successfully.');
    }
}
