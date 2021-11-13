<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest\Symfony;

use Composer\Composer;
use HDNET\Standard\Manifest\ManifestFactoryInterface;

class StaticAnalysisConfigFilesManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        return [
            'copy-from-package' => [
                'static-analysis-files-symfony/' => '',
            ],
        ];
    }
}
