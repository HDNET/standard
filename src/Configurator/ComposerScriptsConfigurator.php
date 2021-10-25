<?php

declare(strict_types=1);

namespace HDNET\Standard\Configurator;

use Composer\Factory;
use Composer\Json\JsonFile;
use Composer\Json\JsonManipulator;

class ComposerScriptsConfigurator extends AbstractConfigurator
{
    public function configure($config, array $options = []): void
    {
        $scripts = $config;

        $json = new JsonFile(Factory::getComposerFile());

        $jsonContents = $json->read();
        $autoScripts = $jsonContents['scripts']['auto-scripts'] ?? [];
        $autoScripts = array_merge($autoScripts, $scripts);

        $manipulator = new JsonManipulator(file_get_contents($json->getPath()));
        $manipulator->addSubNode('scripts', 'auto-scripts', $autoScripts);

        file_put_contents($json->getPath(), $manipulator->getContents());
    }

    public function unconfigure($config): void
    {
        $scripts = $config;

        $json = new JsonFile(Factory::getComposerFile());

        $jsonContents = $json->read();
        $autoScripts = $jsonContents['scripts']['auto-scripts'] ?? [];
        foreach (array_keys($scripts) as $cmd) {
            unset($autoScripts[$cmd]);
        }

        $manipulator = new JsonManipulator(file_get_contents($json->getPath()));
        $manipulator->addSubNode('scripts', 'auto-scripts', $autoScripts);

        file_put_contents($json->getPath(), $manipulator->getContents());
    }
}
