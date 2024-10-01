<?php

namespace GavreanSean\AssetFiles\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class DatabaseInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset-files:database-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the asset-files database files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->database();
    }

    /**
     * Database.
     */
    protected function database(): void
    {
        $this->migrations();

        $this->seeders();

        $this->info('Publishing the database files completed successfully.');
    }

    /**
     * Migrations.
     */
    protected function migrations(): void
    {
        foreach ((new Filesystem)->allFiles(__DIR__.'/../../database/migrations') as $allFile) {
            (new Filesystem)->copy(__DIR__.'/../../database/migrations/'.$allFile->getFilename(), database_path('migrations/'.$allFile->getFilename()));

            unset($allFile);
        }
    }

    /**
     * Seeders.
     */
    protected function seeders(): void
    {
        foreach ((new Filesystem)->allFiles(__DIR__.'/../../database/seeders') as $allFile) {
            (new Filesystem)->copy(__DIR__.'/../../database/seeders/'.$allFile->getFilename(), database_path('seeders/'.$allFile->getFilename()));

            unset($allFile);
        }
    }
}
