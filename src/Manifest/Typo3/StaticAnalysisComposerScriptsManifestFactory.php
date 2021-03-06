<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest\Typo3;

use Composer\Composer;
use HDNET\Standard\Manifest\ManifestFactoryInterface;

class StaticAnalysisComposerScriptsManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        return [
            'composer-scripts' => [
                'typo3-cms-scripts' => [
                    'typo3cms install:fixfolderstructure',
                ],
                'typo3-setup' => [
                    'typo3 extension:setup',
                ],
                'post-autoload-dump' => [
                    '@typo3-cms-scripts',
                    '@typo3-setup',
                    '@captainhook-setup',
                ],
                'yaml-lint' => [
                    'yaml-lint public/typo3conf/ext/site config/sites .lando.yml bitbucket-pipelines.yml',
                ],
                'captainhook-setup' => [
                    'captainhook install --force',
                ],
                'phpstan' => [
                    'phpstan analyse public/typo3conf/ext/site --level 5',
                ],
                'phpstan-ci' => [
                    '@phpstan --no-interaction --no-ansi --memory-limit=2G --error-format=junit --no-progress',
                ],
                'php-cs-fixer' => [
                    'php-cs-fixer fix --cache-file=var/phpcs.cache',
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
                'test' => [
                    '@test:unit',
                    '@test:functional',
                ],
                'test-coverage' => [
                    '@test:unit:coverage',
                    '@test:functional:coverage',
                ],
                'test:unit' => [
                    'phpunit --configuration=public/typo3conf/ext/site/Tests/Build/UnitTests.xml --testdox',
                ],
                'test:functional' => [
                    'phpunit --configuration=public/typo3conf/ext/site/Tests/Build/FunctionalTests.xml --testdox',
                ],
                'test:unit:coverage' => [
                    '@putenv XDEBUG_MODE=coverage',
                    '@test:unit --coverage-clover test-reports/clover-unit.xml --log-junit ./test-reports/junit-unit.xml --coverage-html ./test-reports/unit',
                ],
                'test:functional:coverage' => [
                    '@putenv XDEBUG_MODE=coverage',
                    '@test:functional --coverage-clover test-reports/clover-functional.xml --log-junit ./test-reports/junit-functional.xml --coverage-html ./test-reports/functional',
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
