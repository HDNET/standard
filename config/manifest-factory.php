<?php

declare(strict_types=1);

use HDNET\Standard\Configurator\ComposerScriptsConfigurator;
use HDNET\Standard\Manifest\GitignoreManifestFactory;
use HDNET\Standard\Manifest\PhpStormMetaManifestFactory;

return [
    'PhpStormMeta' => PhpStormMetaManifestFactory::class,
    'Gitignore' => GitignoreManifestFactory::class,
    'ComposerScripts' => ComposerScriptsConfigurator::class,
];
