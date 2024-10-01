<?php

namespace GavreanSean\AssetFiles;

use Illuminate\Support\Facades\Facade;

class AssetFilesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'asset-files';
    }
}
