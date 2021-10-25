<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use Composer\Composer;

class StaticAnalysisConfigFilesManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        return [
            'copy-from-package' => [
                'static-analysis-files/' => '',
            ],
        ];
    }
}
