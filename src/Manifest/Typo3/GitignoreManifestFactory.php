<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest\Typo3;

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
                '/public/*',
                '!/public/.htaccess',
                '!/public/typo3conf',
                '/public/typo3conf/*',
                '!/public/typo3conf/ext/',
                '/public/typo3conf/ext/*',
                '!/public/typo3conf/ext/site',
                '!/public/typo3conf/LocalConfiguration.php',
                '!/public/typo3conf/AdditionalConfiguration.php',
                '/.env.local',
                '/.env.*.local',
                '/test-reports',
            ],
        ];
    }
}
