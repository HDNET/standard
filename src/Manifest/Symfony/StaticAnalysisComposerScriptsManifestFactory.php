<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest\Symfony;

use Composer\Composer;
use HDNET\Standard\Manifest\ManifestFactoryInterface;

class StaticAnalysisComposerScriptsManifestFactory implements ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array
    {
        return [
            'composer-scripts' => [
                'auto-scripts' => [
                    'cache:clear' => 'symfony-cmd',
                    'assets:install %PUBLIC_DIR%' => 'symfony-cmd',
                ],
                'post-install-cmd' => [
                    '@auto-scripts',
                ],
                'post-update-cmd' => [
                    '@auto-scripts',
                ],
                'symfony' => '@php bin/console',
                'test-php-syntax' => [
                    '@symfony cache:warmup --no-optional-warmers --ansi --no-interaction --env=dev',
                    '@lint-php --dry-run --diff --diff-format=udiff',
                ],
                'test-template-syntax' => [
                    '@symfony lint:twig templates/',
                ],
                'test-config-syntax' => [
                    '@symfony lint:container --ansi --no-interaction --env=dev',
                    '@symfony lint:yaml config ./bitbucket-pipelines.yml ./.lando.yml ./documentation/api --parse-tags --ansi --no-interaction --env=dev',
                    '@symfony doctrine:schema:validate --skip-sync --ansi --no-interaction --env=dev',
                ],
                'prepare-test' => [
                    'Composer\\Config::disableProcessTimeout',
                    '@putenv APP_ENV=test',
                    '@symfony cache:clear --env=test',
                    '@symfony doctrine:database:drop --env=test --force',
                    '@symfony doctrine:database:create --env=test',
                    '@symfony doctrine:migrations:migrate -n --env=test',
                    '@symfony doctrine:fixtures:load -n --env=test',
                ],
                'php-unit' => [
                    '@php bin/phpunit --testdox',
                ],
                'test-coverage' => [
                    '@putenv XDEBUG_MODE=coverage',
                    '@prepare-test',
                    '@php-unit --coverage-clover test-reports/clover.xml --log-junit ./test-reports/junit.xml --coverage-html ./test-reports',
                ],
                'test' => [
                    '@prepare-test',
                    '@php-unit',
                ],
                'yaml-lint' => [
                    'yaml-lint .lando.yml config/',
                ],
                'captainhook-setup' => [
                    'captainhook install --force',
                ],
                'phpstan' => [
                    '@php vendor/bin/phpstan --ansi --no-interaction analyse --configuration=phpstan.neon',
                ],
                'phpstan-ci' => [
                    '@phpstan --no-interaction --no-ansi --memory-limit=2G --error-format=junit --no-progress',
                ],
                'php-cs-fixer' => [
                    '@php vendor/bin/php-cs-fixer fix --ansi',
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
