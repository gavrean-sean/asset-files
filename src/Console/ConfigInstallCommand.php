<?php

namespace GavreanSean\AssetFiles\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ConfigInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset-files:config-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the asset-files config files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->config();
    }

    /**
     * Config.
     */
    protected function config(): void
    {
        (new Filesystem)->copy(__DIR__.'/../../config/asset-files.php', config_path('asset-files.php'));

        $this->info('Publishing the config files completed successfully.');
    }
}
