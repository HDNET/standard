<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use HDNET\Standard\Manifest\Symfony\StaticAnalysisComposerScriptsManifestFactory as SymfonyStaticAnalysisComposerScriptsManifestFactory;
use HDNET\Standard\Manifest\Typo3\StaticAnalysisComposerScriptsManifestFactory as Typo3StaticAnalysisComposerScriptsManifestFactory;

class StaticAnalysisComposerScriptsManifestFactory extends AbstractManifestProjectDependentFactory
{
    protected function getSymfonyManifestFactoryClass(): string
    {
        return SymfonyStaticAnalysisComposerScriptsManifestFactory::class;
    }

    protected function getTypo3ManifestFactoryClass(): string
    {
        return Typo3StaticAnalysisComposerScriptsManifestFactory::class;
    }
}
