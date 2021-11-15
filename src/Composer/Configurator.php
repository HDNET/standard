<?php

declare(strict_types=1);

namespace HDNET\Standard\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use HDNET\Standard\Configurator\AbstractConfigurator;
use HDNET\Standard\Configurator\ComposerScriptsConfigurator;
use HDNET\Standard\Configurator\CopyFromPackageConfigurator;
use HDNET\Standard\Configurator\GitignoreConfigurator;

class Configurator
{
    protected array $configurators;
    protected array $cache = [];

    public function __construct(protected Composer $composer, protected IOInterface $io, protected Options $options, protected PackageInterface $pluginPackage)
    {
        // $composer->getPackage()->getExtra()
        // get configuration
        // ordered list of configurators
        $this->configurators = [
            'copy-from-package' => CopyFromPackageConfigurator::class,
            // 'env' => EnvConfigurator::class,
            'composer-scripts' => ComposerScriptsConfigurator::class,
            'gitignore' => GitignoreConfigurator::class,
        ];
    }

    public function install(array $manifest, array $options = []): void
    {
        foreach (array_keys($this->configurators) as $key) {
            if (isset($manifest[$key])) {
                $this->get($key)->configure($manifest[$key], $options);
            }
        }
    }

    public function unconfigure(array $manifest): void
    {
        foreach (array_keys($this->configurators) as $key) {
            if (isset($manifest[$key])) {
                $this->get($key)->unconfigure($manifest[$key]);
            }
        }
    }

    protected function get($key): AbstractConfigurator
    {
        if (!isset($this->configurators[$key])) {
            throw new \InvalidArgumentException(sprintf('Unknown configurator "%s".', $key));
        }

        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $class = $this->configurators[$key];

        $configurator = new $class($this->composer, $this->io, $this->options, $this->pluginPackage);

        if (!($configurator instanceof AbstractConfigurator)) {
            throw new \RuntimeException('The class needs to be an AbstractConfigurator');
        }

        return $this->cache[$key] = $configurator;
    }
}
