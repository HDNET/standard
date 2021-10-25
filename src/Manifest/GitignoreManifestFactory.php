<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use Composer\Composer;

class GitignoreManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        $gitignore = $manifest['gitignore'] ?? [];

        $manifest['gitignore'] = array_merge($gitignore, [
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
            '!/public/typo3conf/LocalConfiguration.php',
            '!/public/typo3conf/AdditionalConfiguration.php',
            '/.env.local',
            '/.env.*.local',
            '/test-reports',
        ]);

        return $manifest;
    }
}
