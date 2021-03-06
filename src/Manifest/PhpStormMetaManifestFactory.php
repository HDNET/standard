<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use Composer\Composer;

class PhpStormMetaManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        return [
            'copy-from-package' => [
                '.phpstorm.meta.php' => '.phpstorm.meta.php',
            ],
        ];
    }
}
