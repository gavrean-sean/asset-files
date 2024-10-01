<?php

namespace GavreanSean\PackageGenerator\Console;

use Illuminate\Console\Command;

class StubsInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package-generator:stubs-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the package-generator stubs files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->stubs();
    }

    /**
     * Stubs.
     */
    protected function stubs(): void
    {
        //

        $this->info('Publishing the stubs files completed successfully.');
    }
}
