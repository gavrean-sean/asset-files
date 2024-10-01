<?php

namespace GavreanSean\AssetFiles\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset-files:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the asset-files package files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->start();

        $this->startInstallation();

        $this->end();
    }

    /**
     * Start.
     */
    protected function start(): void
    {
        $this->writeln($this->seperator());
    }

    /**
     * Write ln.
     */
    protected function writeln(string $line): void
    {
        echo $line.PHP_EOL;
    }

    /**
     * Seperator.
     */
    protected function seperator(): string
    {
        return '---------------------------------------------------------------------------------------------------------------';
    }

    /**
     * Start installation.
     */
    protected function startInstallation(): void
    {
        foreach (configValue('package_commands') as $packageCommand => $status) {
            if ($status) {
                $this->call('asset-files:'.$packageCommand.'-install');

                $this->writeln($this->seperator());
            }

            unset($packageCommand);

            unset($status);
        }
    }

    /**
     * End.
     */
    protected function end(): void
    {
        $this->info('asset-files scaffolding installed successfully.');

        $this->writeln($this->seperator());

        $this->comment('The installation process was carried out successfully. Please visit your web page.');

        $this->writeln($this->seperator());
    }
}
