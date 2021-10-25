<?php

declare(strict_types=1);

use HDNET\Standard\Manifest\GitignoreManifestFactory;
use HDNET\Standard\Manifest\PhpStormMetaManifestFactory;
use HDNET\Standard\Manifest\StaticAnalysisComposerScriptsManifestFactory;
use HDNET\Standard\Manifest\StaticAnalysisConfigFilesManifestFactory;

return [
    'PhpStormMeta' => PhpStormMetaManifestFactory::class,
    'Gitignore' => GitignoreManifestFactory::class,
    'ComposerScripts' => StaticAnalysisComposerScriptsManifestFactory::class,
    'StaticAnalysisConfigFiles' => StaticAnalysisConfigFilesManifestFactory::class,
];
