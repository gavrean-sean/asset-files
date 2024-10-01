<?php

namespace GavreanSean\AssetFiles\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LangInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset-files:lang-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the asset-files lang files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->lang();
    }

    /**
     * Lang.
     */
    protected function lang(): void
    {
        if ((new Filesystem)->exists(base_path('lang'))) {
            foreach (configValue('supported_languages') as $supportedLanguage) {
                if (! (new Filesystem)->exists(base_path('lang/'.$supportedLanguage))) {
                    (new Filesystem)->makeDirectory(base_path('lang/'.$supportedLanguage));
                }

                foreach ((new Filesystem)->allFiles(__DIR__.'/../../lang/'.$supportedLanguage) as $allFile) {
                    (new Filesystem)->copy(__DIR__.'/../../lang/'.$supportedLanguage.'/'.$allFile->getFilename(), base_path('lang/'.$supportedLanguage.'/'.$allFile->getFilename()));

                    unset($allFile);
                }

                unset($supportedLanguage);
            }
        } else {
            (new Filesystem)->copyDirectory(__DIR__.'/../../lang', base_path('lang'));
        }

        $this->info('Publishing the lang files completed successfully.');
    }
}
