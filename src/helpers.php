<?php

if (! function_exists('assetFilesPackageName')) {
    /**
     * Asset files package name.
     */
    function assetFilesPackageName(): mixed
    {
        return app('asset-files')->packageName();
    }
}

if (! function_exists('assetFilesPackageVersion')) {
    /**
     * Asset files package version.
     */
    function assetFilesPackageVersion(): mixed
    {
        return app('asset-files')->packageVersion();
    }
}

if (! function_exists('assetFilesConfigValue')) {
    /**
     * Asset files config value.
     */
    function assetFilesConfigValue(string $configKeyName = 'package_information.name'): mixed
    {
        return app('asset-files')->configValue($configKeyName);
    }
}
