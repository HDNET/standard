<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use Composer\Composer;

// TODO: Can be do this even better? (add namespace to current class name?)
abstract class AbstractManifestProjectDependentFactory implements ManifestFactoryInterface
{
    abstract protected function getSymfonyManifestFactoryClass(): string;

    abstract protected function getTypo3ManifestFactoryClass(): string;

    public function process(Composer $composer, array $manifest): array
    {
        $isTypo3CorePackageInstalled = false;
        foreach ($composer->getPackage()->getRequires() as $require) {
            if ('typo3/cms-core' === $require->getTarget()) {
                $isTypo3CorePackageInstalled = true;
                break;
            }
        }

        if ($isTypo3CorePackageInstalled) {
            $manifestFactoryClass = $this->getTypo3ManifestFactoryClass();
        } else {
            $manifestFactoryClass = $this->getSymfonyManifestFactoryClass();
        }

        return (new $manifestFactoryClass())->process($composer, $manifest);
    }
}
