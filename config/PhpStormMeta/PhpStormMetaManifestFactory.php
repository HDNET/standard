<?php

declare(strict_types=1);

class PhpStormMetaManifestFactory implements \HDNET\Standard\Manifest\ManifestFactoryInterface
{
    public function process(Composer\Composer $composer, array $manifest): array
    {
        $manifest['copy-from-package']['.phpstorm.meta.php'] = '%ROOT_DIR%';

        return $manifest;
    }
}
