<?php

declare(strict_types=1);

use HDNET\Standard\Manifest\GitignoreManifestFactory;
use HDNET\Standard\Manifest\PhpStormMetaManifestFactory;
use HDNET\Standard\Manifest\StaticAnalysisComposerScriptsManifestFactory;

return [
    'PhpStormMeta' => PhpStormMetaManifestFactory::class,
    'Gitignore' => GitignoreManifestFactory::class,
    'ComposerScripts' => StaticAnalysisComposerScriptsManifestFactory::class,
];
