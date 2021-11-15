<?php

declare(strict_types=1);

use HDNET\Standard\PreSet\PreSetInterface;
use HDNET\Standard\PreSet\RectorPreSet;
use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/public/typo3conf/ext/site',
    ]);

    RectorPreSet::load($containerConfigurator, PreSetInterface::SYSTEM_TYPO3);
};
