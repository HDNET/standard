<?php

declare(strict_types=1);

namespace HDNET\Standard\Composer;

use Composer\Composer;
use Composer\Config;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use HDNET\Standard\Manifest\ManifestFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @const string
     */
    public const PACKAGE_NAME = 'hdnet/standard';

    protected Composer $composer;
    protected IOInterface $io;
    protected Config $config;
    protected EventDispatcher $dispatcher;
    protected Configurator $configurator;
    protected array $manifest;
    protected Options $options;

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;
        $this->config = $composer->getConfig();
        $this->dispatcher = new EventDispatcher();
        $this->options = new Options($composer, $io);
        $this->configurator = new Configurator($composer, $io, $this->options);

        echo $this->composer->getPackage()->getName();
        exit;
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PackageEvents::POST_PACKAGE_INSTALL => 'installPackage',
            PackageEvents::POST_PACKAGE_UPDATE => 'updatePackage',
            PackageEvents::POST_PACKAGE_UNINSTALL => 'uninstallPackage',
        ];
    }

    public function installPackage(PackageEvent $event): void
    {
        if (self::PACKAGE_NAME !== $event->getName()) {
            return;
        }

        $this->io->info('Install of the standard package');
        $this->installHDNETStandard();
    }

    public function updatePackage(PackageEvent $event): void
    {
        if (self::PACKAGE_NAME !== $event->getName()) {
            return;
        }

        $this->io->info('Update of the standard package');
        $this->uninstallHDNETStandard();
        $this->installHDNETStandard();
    }

    public function uninstallPackage(PackageEvent $event): void
    {
        if (self::PACKAGE_NAME !== $event->getName()) {
            return;
        }

        $this->io->info('Update of the standard package');
        $this->uninstallHDNETStandard();
    }

    protected function setupManifest(): void
    {
        $extra = $this->composer->getPackage()->getExtra();
        if (!isset($extra['hdnet-standard'])) {
            $this->io->info('HDNET-Standard: No configuration file specified. Using the default path.');
        }
        $manifestFactoryFilepath = $extra['hdnet-standard'] ?? $this->composer->getInstallationManager()->getInstallPath($this->composer->getPackage()).\DIRECTORY_SEPARATOR.'hdnet-standard.php';
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
