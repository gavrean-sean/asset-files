<?php

namespace GavreanSean\PackageGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PackageGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:generator {vendor=gavrean-sean} {package=package-name} {author=Gavrean Sean} {email=gavreansean@gmail.com} {description=package-name description.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a package from gavrean-sean/package-generator repository';

    /**
     * Package properties.
     */
    protected array $packageProperties = [
        'from' => [
            'vendor' => 'gavrean-sean',
            'package' => 'package-generator',
            'author' => 'Gavrean Sean',
            'email' => 'gavreansean@gmail.com',
            'description' => 'Simple Package To Quickly Generate Basic Structure For Other Laravel Packages.',
            'path' => null,
            'class_file' => 'PackageGenerator',
        ],
        'to' => [
            'vendor' => null,
            'package' => null,
            'author' => null,
            'email' => null,
            'description' => null,
            'path' => null,
            'class_file' => null,
        ],
    ];

    /**
     * Default messages.
     */
    protected array $defaultMessages = [
        'package_properties' => '01 -> The package properties definition process completed successfully.',
        'check_package_folder' => '02 -> The package directory check completed successfully.',
        'editorconfig' => '03 -> Copying the .editorconfig file into the package directory has been completed successfully.',
        'github' => '04 -> Copying the .github directory into the package directory has been completed successfully.',
        'gitignore' => '05 -> Copying the .gitignore file into the package directory has been completed successfully.',
        'changelog' => '06 -> Copying the CHANGELOG.md file into the package directory has been completed successfully.',
        'license' => '07 -> Copying the LICENSE.md file into the package directory has been completed successfully.',
        'readme' => '08 -> Copying the README.md file into the package directory has been completed successfully.',
        'todo' => '09 -> Copying the TODO.md file into the package directory has been completed successfully.',
        'tree' => '10 -> Copying the TREE.md file into the package directory has been completed successfully.',
        'assets' => '11 -> Copying the assets directory into the package directory has been completed successfully.',
        'composer' => '12 -> Copying the composer.json file into the package directory has been completed successfully.',
        'config' => '13 -> Copying the config file into the package directory has been completed successfully.',
        'database' => '14 -> Copying the database directory into the package directory has been completed successfully.',
        'lang' => '15 -> Copying the lang directory into the package directory has been completed successfully.',
        'resources' => '16 -> Copying the resources directory into the package directory has been completed successfully.',
        'routes' => '17 -> Copying the routes directory into the package directory has been completed successfully.',
        'install_command' => '18 -> Copying the src/Console/InstallCommand.php files into the package directory has been completed successfully.',
        'main_class' => '19 -> Copying the src/PackageGenerator.php file into the package directory has been completed successfully.',
        'facade_class' => '20 -> Copying the src/PackageGeneratorFacade.php file into the package directory has been completed successfully.',
        'provider_class' => '21 -> Copying the src/PackageGeneratorServiceProvider.php file into the new package directory has been completed successfully.',
        'helpers' => '22 -> Copying the src/helpers.php file into the new package directory has been completed successfully.',
        'stubs' => '23 -> Copying the stubs directory into the package directory has been completed successfully.',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->start();

        $this->packageProperties();

        $this->checkPackageFolder();

        $this->packageConfigurations();

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
     * Package properties.
     */
    protected function packageProperties(): void
    {
        $this->packageProperties['from']['path'] = base_path('vendor/'.$this->packageProperties['from']['vendor'].'/'.$this->packageProperties['from']['package']);

        $this->packageProperties['to']['vendor'] = str($this->argument('vendor'))->lower()->slug();

        $this->packageProperties['to']['package'] = str($this->argument('package'))->lower()->slug();

        $this->packageProperties['to']['author'] = str($this->argument('author'))->lower()->title();

        $this->packageProperties['to']['email'] = str($this->argument('email'))->lower();

        $this->packageProperties['to']['description'] = str($this->argument('description'))->lower()->replace('-', ' ')->title();

        $this->packageProperties['to']['path'] = base_path('packages/'.$this->packageProperties['to']['vendor'].'/'.$this->packageProperties['to']['package']);

        $this->packageProperties['to']['class_file'] = str($this->packageProperties['to']['package'])->lower()->title()->replace('-', '');

        $this->info($this->defaultMessages['package_properties']);

        $this->writeln($this->seperator());
    }

    /**
     * Check package folder.
     */
    protected function checkPackageFolder(): void
    {
        $vendorFolderName = base_path('packages/'.$this->packageProperties['to']['vendor']);

        $packageFolderName = base_path('packages/'.$this->packageProperties['to']['vendor'].'/'.$this->packageProperties['to']['package']);

        if (! (new Filesystem)->exists($vendorFolderName)) {
            (new Filesystem)->makeDirectory($vendorFolderName);
        }

        if (! (new Filesystem)->exists($packageFolderName)) {
            (new Filesystem)->makeDirectory($packageFolderName);
        }

        $this->info($this->defaultMessages['check_package_folder']);

        $this->writeln($this->seperator());
    }

    /**
     * Package configurations.
     */
    protected function packageConfigurations(): void
    {
        $this->editorconfig();

        $this->github();

        $this->gitignore();

        $this->changelog();

        $this->license();

        $this->readme();

        $this->todo();

        $this->tree();

        $this->assets();

        $this->composer();

        $this->config();

        $this->database();

        $this->lang();

        $this->resources();

        $this->routes();

        $this->src();

        $this->stubs();
    }

    /**
     * Editorconfig.
     */
    protected function editorconfig(): void
    {
        $fileName = '.editorconfig';

        $this->checkPackageFiles($fileName, $fileName);

        $this->info($this->defaultMessages['editorconfig']);

        $this->writeln($this->seperator());
    }

    /**
     * Github.
     */
    protected function github(): void
    {
        $folderName = '.github';

        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$folderName)) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$folderName);
        }

        (new Filesystem)->copyDirectory($this->packageProperties['from']['path'].'/'.$folderName, $this->packageProperties['to']['path'].'/'.$folderName);

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['vendor'].'/'.$this->packageProperties['from']['package'],
            $this->packageProperties['to']['vendor'].'/'.$this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/'.$folderName.'/ISSUE_TEMPLATE/config.yml'
        );

        $this->info($this->defaultMessages['github']);

        $this->writeln($this->seperator());
    }

    /**
     * Gitignore.
     */
    protected function gitignore(): void
    {
        $fileName = '.gitignore';

        $this->checkPackageFiles($fileName, $fileName);

        $this->info($this->defaultMessages['gitignore']);

        $this->writeln($this->seperator());
    }

    /**
     * Changelog.
     */
    protected function changelog(): void
    {
        $fileName = 'CHANGELOG.md';

        $this->checkPackageFiles($fileName, $fileName);

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        $this->info($this->defaultMessages['changelog']);

        $this->writeln($this->seperator());
    }

    /**
     * License.
     */
    protected function license(): void
    {
        $fileName = 'LICENSE.md';

        $this->checkPackageFiles($fileName, $fileName);

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['author'].' <'.$this->packageProperties['from']['email'].'>',
            $this->packageProperties['to']['author'].' <'.$this->packageProperties['to']['email'].'>',
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        $this->info($this->defaultMessages['license']);

        $this->writeln($this->seperator());
    }

    /**
     * Readme.
     */
    protected function readme(): void
    {
        $fileName = 'README.md';

        $this->checkPackageFiles($fileName, $fileName);

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['email'],
            $this->packageProperties['to']['email'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['vendor'],
            $this->packageProperties['to']['vendor'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            str($this->packageProperties['from']['description'])->lower()->slug('+')->title(),
            str($this->packageProperties['to']['description'])->lower()->slug('+')->title(),
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['description'],
            $this->packageProperties['to']['description'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            str($this->packageProperties['from']['package'])->lower()->title()->replace('-', ' ').' Page',
            str($this->packageProperties['to']['package'])->lower()->title()->replace('-', ' ').' Page',
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['author'],
            $this->packageProperties['to']['author'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            '['.str($this->packageProperties['from']['package'])->lower()->title()->replace('-', ' ').'](https://github.com/'.$this->packageProperties['to']['vendor'].'/'.$this->packageProperties['to']['package'].').',
            '['.str($this->packageProperties['from']['package'])->lower()->title()->replace('-', ' ').'](https://github.com/'.$this->packageProperties['from']['vendor'].'/'.$this->packageProperties['from']['package'].').',
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        $this->info($this->defaultMessages['readme']);

        $this->writeln($this->seperator());
    }

    /**
     * Todo.
     */
    protected function todo(): void
    {
        $fileName = 'TODO.md';

        $this->checkPackageFiles($fileName, $fileName);

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        $this->info($this->defaultMessages['todo']);

        $this->writeln($this->seperator());
    }

    /**
     * Tree.
     */
    protected function tree(): void
    {
        $fileName = 'TREE.md';

        $this->checkPackageFiles($fileName, $fileName);

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            str($this->packageProperties['from']['package'])->replace('-', '_'),
            str($this->packageProperties['to']['package'])->replace('-', '_'),
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['class_file'],
            $this->packageProperties['to']['class_file'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        $this->info($this->defaultMessages['tree']);

        $this->writeln($this->seperator());
    }

    /**
     * Assets.
     */
    protected function assets(): void
    {
        $mainFolderName = 'assets';

        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName)) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName);
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName);

        $subFolderNames = [
            'images',
        ];

        foreach ($subFolderNames as $subFolderName) {
            if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$subFolderName)) {
                (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$subFolderName);
            }

            (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$subFolderName);

            foreach ((new Filesystem)->allFiles($this->packageProperties['from']['path'].'/'.$mainFolderName.'/'.$subFolderName) as $allFile) {
                $this->checkPackageFiles($mainFolderName.'/'.$subFolderName.'/'.$allFile->getFilename(), $mainFolderName.'/'.$subFolderName.'/'.$allFile->getFilename());

                unset($allFile);
            }

            unset($subFolderName);
        }

        $this->info($this->defaultMessages['assets']);

        $this->writeln($this->seperator());
    }

    /**
     * Composer.
     */
    protected function composer(): void
    {
        $fileName = 'composer.json';

        $this->checkPackageFiles($fileName, $fileName);

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['email'],
            $this->packageProperties['to']['email'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['vendor'],
            $this->packageProperties['to']['vendor'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['description'],
            $this->packageProperties['to']['description'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['author'],
            $this->packageProperties['to']['author'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            str($this->packageProperties['from']['vendor'])->lower()->title()->replace('-', ''),
            str($this->packageProperties['to']['vendor'])->lower()->title()->replace('-', ''),
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['class_file'],
            $this->packageProperties['to']['class_file'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        $this->info($this->defaultMessages['composer']);

        $this->writeln($this->seperator());
    }

    /**
     * Config.
     */
    protected function config(): void
    {
        $folderName = 'config';

        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$folderName)) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$folderName);
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$folderName);

        $this->checkPackageFiles($folderName.'/'.$this->packageProperties['from']['package'].'.php', $folderName.'/'.$this->packageProperties['to']['package'].'.php');

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/'.$folderName.'/'.$this->packageProperties['to']['package'].'.php'
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['description'],
            $this->packageProperties['to']['description'],
            $this->packageProperties['to']['path'].'/'.$folderName.'/'.$this->packageProperties['to']['package'].'.php'
        );

        $this->info($this->defaultMessages['config']);

        $this->writeln($this->seperator());
    }

    /**
     * Database.
     */
    protected function database(): void
    {
        $mainFolderName = 'database';

        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName)) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName);
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName);

        $folderNames = [
            'migrations',
            'seeders',
        ];

        foreach ($folderNames as $folderName) {
            if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName)) {
                (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName);
            }

            (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName);

            if ($folderName === 'migrations') {
                $this->checkPackageFiles($mainFolderName.'/'.$folderName.'/create_'.str($this->packageProperties['from']['package'])->replace('-', '_').'_table.php',
                    $mainFolderName.'/'.$folderName.'/'.date('Y_m_d_His').'_create_'.str($this->packageProperties['to']['package'])->replace('-', '_').'_table.php');

                (new Filesystem)->replaceInFile(
                    str($this->packageProperties['from']['package'])->replace('-', '_'),
                    str($this->packageProperties['to']['package'])->replace('-', '_'),
                    $this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.date('Y_m_d_His').'_create_'.str($this->packageProperties['to']['package'])->replace('-', '_').'_table.php'
                );
            }

            if ($folderName === 'seeders') {
                $this->checkPackageFiles($mainFolderName.'/'.$folderName.'/'.$this->packageProperties['from']['class_file'].'Seeder.php', $mainFolderName.'/'.$folderName.'/'.$this->packageProperties['to']['class_file'].'Seeder.php');

                (new Filesystem)->replaceInFile(
                    $this->packageProperties['from']['class_file'],
                    $this->packageProperties['to']['class_file'],
                    $this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$this->packageProperties['to']['class_file'].'Seeder.php'
                );
            }

            unset($folderName);
        }

        $this->info($this->defaultMessages['database']);

        $this->writeln($this->seperator());
    }

    /**
     * Lang.
     */
    protected function lang(): void
    {
        $mainFolderName = 'lang';

        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName)) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName);
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName);

        foreach (configValue('supported_languages') as $supportedLanguage) {
            if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$supportedLanguage)) {
                (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$supportedLanguage);
            }

            (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$supportedLanguage);

            $this->checkPackageFiles($mainFolderName.'/'.$supportedLanguage.'/'.$this->packageProperties['from']['package'].'.php', $mainFolderName.'/'.$supportedLanguage.'/'.$this->packageProperties['to']['package'].'.php');

            (new Filesystem)->replaceInFile(
                str($this->packageProperties['from']['package'])->lower()->title()->replace('-', ' '),
                str($this->packageProperties['to']['package'])->lower()->title()->replace('-', ' '),
                $this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$supportedLanguage.'/'.$this->packageProperties['to']['package'].'.php'
            );

            (new Filesystem)->replaceInFile(
                $this->packageProperties['from']['package'],
                $this->packageProperties['to']['package'],
                $this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$supportedLanguage.'/'.$this->packageProperties['to']['package'].'.php'
            );

            (new Filesystem)->replaceInFile(
                $this->packageProperties['from']['description'],
                $this->packageProperties['to']['description'],
                $this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$supportedLanguage.'/'.$this->packageProperties['to']['package'].'.php'
            );

            unset($supportedLanguage);
        }

        $this->info($this->defaultMessages['lang']);

        $this->writeln($this->seperator());
    }

    /**
     * Resources.
     */
    protected function resources(): void
    {
        $mainFolderName = 'resources';

        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName)) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName);
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName);

        $folderNames = [
            'views' => [
                'pages' => [
                    'home',
                ],
            ],
        ];

        $pageViewName = 'index';

        foreach ($folderNames as $folderName => $subFolderName) {
            if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName)) {
                (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName);
            }

            (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName);

            if ($subFolderName != '') {
                foreach ($subFolderName as $subFolder => $item) {
                    if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$subFolder)) {
                        (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$subFolder);
                    }

                    (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$subFolder);

                    if ($item != '') {
                        foreach ($item as $v) {
                            if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$subFolder.'/'.$v)) {
                                (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$subFolder.'/'.$v);
                            }

                            (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$subFolder.'/'.$v);

                            $this->checkPackageFiles($mainFolderName.'/'.$folderName.'/'.$subFolder.'/'.$v.'/'.$pageViewName.'.blade.php', $mainFolderName.'/'.$folderName.'/'.$subFolder.'/'.$v.'/'.$pageViewName.'.blade.php');

                            (new Filesystem)->replaceInFile(
                                $this->packageProperties['from']['description'],
                                $this->packageProperties['to']['description'],
                                $this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$subFolder.'/'.$v.'/'.$pageViewName.'.blade.php'
                            );

                            (new Filesystem)->replaceInFile(
                                $this->packageProperties['from']['vendor'].'/'.$this->packageProperties['from']['package'],
                                $this->packageProperties['to']['vendor'].'/'.$this->packageProperties['to']['package'],
                                $this->packageProperties['to']['path'].'/'.$mainFolderName.'/'.$folderName.'/'.$subFolder.'/'.$v.'/'.$pageViewName.'.blade.php'
                            );

                            unset($v);
                        }
                    }

                    unset($subFolder);

                    unset($item);
                }
            }

            unset($folderName);

            unset($subFolderName);
        }

        $this->info($this->defaultMessages['resources']);

        $this->writeln($this->seperator());
    }

    /**
     * Routes.
     */
    protected function routes(): void
    {
        $folderName = 'routes';

        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$folderName)) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$folderName);
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$folderName);

        $this->checkPackageFiles($folderName.'/'.$this->packageProperties['from']['package'].'.php', $folderName.'/'.$this->packageProperties['to']['package'].'.php');

        $this->info($this->defaultMessages['routes']);

        $this->writeln($this->seperator());
    }

    /**
     * Src.
     */
    protected function src(): void
    {
        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/src')) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/src');
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/src');

        $this->console();

        $this->mainClass();

        $this->facadeClass();

        $this->providerClass();

        $this->helpers();
    }

    /**
     * Console.
     */
    protected function console(): void
    {
        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/src/Console')) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/src/Console');
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/src/Console');

        $this->command();
    }

    /**
     * Command.
     */
    protected function command(): void
    {
        $fileNames = [
            'src/Console/AssetsInstallCommand.php',
            'src/Console/ConfigInstallCommand.php',
            'src/Console/DatabaseInstallCommand.php',
            'src/Console/InstallCommand.php',
            'src/Console/LangInstallCommand.php',
            'src/Console/OptimizeConfigurationCommand.php',
            'src/Console/ResourcesInstallCommand.php',
            'src/Console/RoutesInstallCommand.php',
            'src/Console/StubsInstallCommand.php',
        ];

        foreach ($fileNames as $fileName) {
            $this->checkPackageFiles($fileName, $fileName);

            (new Filesystem)->replaceInFile(
                str($this->packageProperties['from']['vendor'])->lower()->title()->replace('-', ''),
                str($this->packageProperties['to']['vendor'])->lower()->title()->replace('-', ''),
                $this->packageProperties['to']['path'].'/'.$fileName
            );

            (new Filesystem)->replaceInFile(
                $this->packageProperties['from']['class_file'],
                $this->packageProperties['to']['class_file'],
                $this->packageProperties['to']['path'].'/'.$fileName
            );

            (new Filesystem)->replaceInFile(
                $this->packageProperties['from']['package'],
                $this->packageProperties['to']['package'],
                $this->packageProperties['to']['path'].'/'.$fileName
            );

            unset($fileName);
        }

        $this->info($this->defaultMessages['install_command']);

        $this->writeln($this->seperator());
    }

    /**
     * Main class.
     */
    protected function mainClass(): void
    {
        $this->checkPackageFiles('src/'.$this->packageProperties['from']['class_file'].'.php', 'src/'.$this->packageProperties['to']['class_file'].'.php');

        (new Filesystem)->replaceInFile(
            str($this->packageProperties['from']['vendor'])->lower()->title()->replace('-', ''),
            str($this->packageProperties['to']['vendor'])->lower()->title()->replace('-', ''),
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'.php'
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['class_file'],
            $this->packageProperties['to']['class_file'],
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'.php'
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'.php'
        );

        $this->info($this->defaultMessages['main_class']);

        $this->writeln($this->seperator());
    }

    /**
     * Facade class.
     */
    protected function facadeClass(): void
    {
        $this->checkPackageFiles('src/'.$this->packageProperties['from']['class_file'].'Facade.php', 'src/'.$this->packageProperties['to']['class_file'].'Facade.php');

        (new Filesystem)->replaceInFile(
            str($this->packageProperties['from']['vendor'])->lower()->title()->replace('-', ''),
            str($this->packageProperties['to']['vendor'])->lower()->title()->replace('-', ''),
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'Facade.php'
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['class_file'],
            $this->packageProperties['to']['class_file'],
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'Facade.php'
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'Facade.php'
        );

        $this->info($this->defaultMessages['facade_class']);

        $this->writeln($this->seperator());
    }

    /**
     * Provider class.
     */
    protected function providerClass(): void
    {
        $this->checkPackageFiles('src/'.$this->packageProperties['from']['class_file'].'ServiceProvider.php', 'src/'.$this->packageProperties['to']['class_file'].'ServiceProvider.php');

        (new Filesystem)->replaceInFile(
            str($this->packageProperties['from']['vendor'])->lower()->title()->replace('-', ''),
            str($this->packageProperties['to']['vendor'])->lower()->title()->replace('-', ''),
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'ServiceProvider.php'
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['class_file'],
            $this->packageProperties['to']['class_file'],
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'ServiceProvider.php'
        );

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/src/'.$this->packageProperties['to']['class_file'].'ServiceProvider.php'
        );

        $this->info($this->defaultMessages['provider_class']);

        $this->writeln($this->seperator());
    }

    /**
     * Helpers.
     */
    protected function helpers(): void
    {
        $fileName = 'src/helpers.php';

        $this->checkPackageFiles($fileName, $fileName);

        (new Filesystem)->replaceInFile(
            $this->packageProperties['from']['package'],
            $this->packageProperties['to']['package'],
            $this->packageProperties['to']['path'].'/'.$fileName
        );

        $this->info($this->defaultMessages['helpers']);

        $this->writeln($this->seperator());
    }

    /**
     * Stubs.
     */
    protected function stubs(): void
    {
        $folderName = 'stubs';

        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$folderName)) {
            (new Filesystem)->deleteDirectory($this->packageProperties['to']['path'].'/'.$folderName);
        }

        (new Filesystem)->makeDirectory($this->packageProperties['to']['path'].'/'.$folderName);

        $this->checkPackageFiles($folderName.'/.gitkeep', $folderName.'/.gitkeep');

        $this->info($this->defaultMessages['stubs']);

        $this->writeln($this->seperator());
    }

    /**
     * Check package files.
     */
    protected function checkPackageFiles(string $fromFileName, string $toFileName): void
    {
        if ((new Filesystem)->exists($this->packageProperties['to']['path'].'/'.$toFileName)) {
            (new Filesystem)->delete($this->packageProperties['to']['path'].'/'.$toFileName);
        }

        (new Filesystem)->copy($this->packageProperties['from']['path'].'/'.$fromFileName, $this->packageProperties['to']['path'].'/'.$toFileName);
    }

    /**
     * End.
     */
    protected function end(): void
    {
        $this->info('The new package creation was successful.');

        $this->writeln($this->seperator());

        $this->comment('Your new package has been created. You can see the files and directories of your package that you have created in the packages directory.');

        $this->writeln($this->seperator());
    }
}
