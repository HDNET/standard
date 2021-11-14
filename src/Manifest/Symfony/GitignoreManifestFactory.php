<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest\Symfony;

use Composer\Composer;
use HDNET\Standard\Manifest\ManifestFactoryInterface;

class GitignoreManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        return [
            'gitignore' => [
                '.DS_Store',
                '/.idea/*',
                '!/.idea/icon.svg',
                '/.php-cs-fixer.cache',
                'nbproject',
                '/var/*',
                '/vendor',
            ],
        ];
    }
}
