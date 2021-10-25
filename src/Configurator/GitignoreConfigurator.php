<?php

declare(strict_types=1);

namespace HDNET\Standard\Configurator;

class GitignoreConfigurator extends AbstractConfigurator
{
    public function configure($config, array $options = []): void
    {
        $vars = $config;

        $this->write('Adding entries to .gitignore');

        $gitignore = $this->options->get('root-dir').'/.gitignore';
        if (empty($options['force']) && $this->isFileMarked($gitignore)) {
            return;
        }

        $data = '';
        foreach ($vars as $value) {
            $value = $this->options->expandTargetDir($value);
            $data .= "$value\n";
        }
        $data = "\n".ltrim($this->markData($data), "\r\n");

        if (!$this->updateData($gitignore, $data)) {
            file_put_contents($gitignore, $data, \FILE_APPEND);
        }
    }

    public function unconfigure($config): void
    {
        $vars = $config;

        $file = $this->options->get('root-dir').'/.gitignore';
        if (!file_exists($file)) {
            return;
        }

        $contents = preg_replace(sprintf('{%s*###> %s ###.*###< %s ###%s+}s', "\n", self::NAME, self::NAME, "\n"), "\n", file_get_contents($file), -1, $count);
        if (!$count) {
            return;
        }

        $this->write('Removing entries in .gitignore');
        file_put_contents($file, ltrim($contents, "\r\n"));
    }
}
