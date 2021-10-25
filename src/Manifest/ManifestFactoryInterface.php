<?php

declare(strict_types=1);

namespace HDNET\Standard\Manifest;

use Composer\Composer;

interface ManifestFactoryInterface
{
    public function process(Composer $composer, array $manifest): array;
}
