<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use Composer\Composer;

class StaticAnalysisComposerScriptsManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        return [
            'composer-scripts' => [
                'yaml-lint' => [
                    'yaml-lint .lando.yml',
                ],
                'captainhook-setup' => [
                    'captainhook install --force',
                ],
                'phpstan' => [
                    'phpstan analyse src config --level 5',
                ],
                'phpstan-ci' => [
                    '@phpstan --no-interaction --no-ansi --memory-limit=2G --error-format=junit --no-progress',
                ],
                'php-cs-fixer' => [
                    'php-cs-fixer fix',
                ],
                'php-cs-fixer-ci' => [
                    '@php-cs-fixer --dry-run --no-ansi --show-progress=none --diff --format=junit',
                ],
                'psalm' => [
                    'psalm',
                ],
                'psalm-ci' => [
                    '@psalm --no-cache --no-file-cache --no-progress --memory-limit=2G --output-format=junit',
                ],
                'rector' => [
                    'rector',
                ],
                'code' => [
                    '@yaml-lint',
                    '@rector',
                    '@phpstan',
                    '@php-cs-fixer',
                    '@psalm --no-cache',
                ],
                'code:check' => [
                    '@yaml-lint',
                    '@phpstan',
                    '@php-cs-fixer --dry-run',
                    '@psalm',
                ],
            ],
        ];
    }
}
