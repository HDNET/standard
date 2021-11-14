<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use HDNET\Standard\Manifest\Symfony\StaticAnalysisConfigFilesManifestFactory as SymfonyStaticAnalysisConfigFilesManifestFactory;
use HDNET\Standard\Manifest\Typo3\StaticAnalysisConfigFilesManifestFactory as Typo3StaticAnalysisConfigFilesManifestFactory;

class StaticAnalysisConfigFilesManifestFactory extends AbstractManifestProjectDependentFactory
{
    protected function getSymfonyManifestFactoryClass(): string
    {
        return SymfonyStaticAnalysisConfigFilesManifestFactory::class;
    }

    protected function getTypo3ManifestFactoryClass(): string
    {
        return Typo3StaticAnalysisConfigFilesManifestFactory::class;
    }
}
