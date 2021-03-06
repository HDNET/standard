<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest\Typo3;

use Composer\Composer;
use HDNET\Standard\Manifest\ManifestFactoryInterface;

class StaticAnalysisConfigFilesManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        return [
            'copy-from-package' => [
                'resources/static-analysis-files-typo3/' => '',
            ],
        ];
    }
}
