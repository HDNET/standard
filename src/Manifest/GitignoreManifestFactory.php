<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use HDNET\Standard\Manifest\Symfony\GitignoreManifestFactory as SymfonyGitignoreManifestFactory;
use HDNET\Standard\Manifest\Typo3\GitignoreManifestFactory as Typo3GitignoreManifestFactory;

class GitignoreManifestFactory extends AbstractManifestProjectDependentFactory
{
    protected function getSymfonyManifestFactoryClass(): string
    {
        return SymfonyGitignoreManifestFactory::class;
    }

    protected function getTypo3ManifestFactoryClass(): string
    {
        return Typo3GitignoreManifestFactory::class;
    }
}
