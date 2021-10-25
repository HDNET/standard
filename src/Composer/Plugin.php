<?php

declare(strict_types=1);

namespace HDNET\Standard\Composer;

use Composer\Composer;
use Composer\Config;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Plugin\PluginInterface;
use Composer\Semver\Constraint\MatchNoneConstraint;
use HDNET\Standard\Manifest\ManifestFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Plugin implements PluginInterface
{
    public \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher;
    /**
     * @const string
     */
    public const PACKAGE_NAME = 'hdnet/standard';

    protected Composer $composer;
    protected IOInterface $io;
    protected Config $config;
    protected array $manifest;
    protected Options $options;
    protected PackageInterface $pluginPackage;
    protected Configurator $configurator;

    protected function setup(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;
        $this->config = $composer->getConfig();
        $this->dispatcher = new EventDispatcher();
        $this->options = new Options($composer, $io);
        $pluginPackage = $this->composer->getRepositoryManager()->getLocalRepository()->findPackage(self::PACKAGE_NAME, '*');
        if (!($pluginPackage instanceof PackageInterface)) {
            $pluginPackage = $this->composer->getRepositoryManager()->findPackage(self::PACKAGE_NAME, new MatchNoneConstraint());

            if (!($pluginPackage instanceof PackageInterface)) {
                throw new \RuntimeException('The hdnet/standard package could not be retrieved!');
            }
        }
        $this->pluginPackage = $pluginPackage;
        $this->configurator = new Configurator($composer, $io, $this->options, $this->pluginPackage);
    }

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->setup($composer, $io);

        $this->io->info('Install of the hdnet/standard package');
        $this->setupManifest();
        $this->installHDNETStandard();
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
        $this->setup($composer, $io);

        $this->io->info('Update of the hdnet/standard package');
        $this->setupManifest();
        $this->uninstallHDNETStandard();
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
        $this->setup($composer, $io);

        $this->io->info('Uninstallation of the hdnet/standard package.');
    }

    protected function setupManifest(): void
    {
        $extra = $this->composer->getPackage()->getExtra();
        if (!isset($extra['hdnet-standard'])) {
            $this->io->info('HDNET-Standard: No configuration file specified. Using the default path.');
        }
        $manifestFactoryFilepath = $extra['hdnet-standard'] ?? $this->composer->getInstallationManager()->getInstallPath($this->pluginPackage)
            .\DIRECTORY_SEPARATOR.'config'.\DIRECTORY_SEPARATOR.'manifest-factory.php';
        $manifestFactoryClassMapping = require $manifestFactoryFilepath;

        foreach ($manifestFactoryClassMapping as $name => $class) {
            $manifestFactory = new $class();
            if (!($manifestFactory instanceof ManifestFactoryInterface)) {
                throw new \RuntimeException('The classes need to be ');
            }
            $this->io->notice('Loading manifest factory '.$name);
            $this->manifest = $manifestFactory->process($this->composer, $this->manifest);
        }
    }

    protected function installHDNETStandard(): void
    {
        $this->configurator->install($this->manifest);
    }

    protected function uninstallHDNETStandard(): void
    {
        $this->configurator->unconfigure($this->manifest);
    }
}
