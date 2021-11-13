<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use Composer\Composer;
use Composer\Package\Package;

// TODO: Can be do this even better? (add namespace to current class name)
abstract class AbstractManifestProjectDependentFactory implements ManifestFactoryInterface
{
    abstract protected function getSymfonyManifestFactoryClass(): string;

    abstract protected function getTypo3ManifestFactoryClass(): string;

    public function process(Composer $composer, array $manifest): array
    {
        $symfonyPackage = new Package('symfony/flex', '*', '*');

        $symfonyInstalled = $composer->getInstallationManager()->isPackageInstalled(
            $composer->getRepositoryManager()->getLocalRepository(),
            $symfonyPackage
        );

        if ($symfonyInstalled) {
            $manifestFactoryClass = $this->getSymfonyManifestFactoryClass();
        } else {
            $manifestFactoryClass = $this->getTypo3ManifestFactoryClass();
        }

        return (new $manifestFactoryClass())->process($composer, $manifest);
    }
}
