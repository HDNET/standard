<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use Composer\Composer;

class PhpStormMetaManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        $manifest['copy-from-package']['.phpstorm.meta.php'] = '%ROOT_DIR%';

        return $manifest;
    }
}
