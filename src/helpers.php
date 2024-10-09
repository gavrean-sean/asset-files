<?php

if (! function_exists('assetFilesPackageName')) {
    /**
     * Package name.
     */
    function assetFilesPackageName(): mixed
    {
        return app('asset-files')->packageName();
    }
}

if (! function_exists('assetFilesPackageVersion')) {
    /**
     * Package version.
     */
    function assetFilesPackageVersion(): mixed
    {
        return app('asset-files')->packageVersion();
    }
}

if (! function_exists('assetFilesConfigValue')) {
    /**
     * Config value.
     */
    function assetFilesConfigValue(string $configKeyName = 'package_information.name'): mixed
    {
        return app('asset-files')->configValue($configKeyName);
    }
}
