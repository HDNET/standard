<?php

declare(strict_types=1);

namespace HDNET\Standard\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Util\ProcessExecutor;

class Options
{
    protected array $options;
    protected array $writtenFiles = [];

    public function __construct(Composer $composer, protected IOInterface $io)
    {
        $extra = $composer->getPackage()->getExtra();

        $this->options = array_merge([
            'bin-dir' => 'bin',
            'conf-dir' => 'conf',
            'config-dir' => 'config',
            'src-dir' => 'src',
            'var-dir' => 'var',
            'public-dir' => 'public',
            'root-dir' => $extra['symfony']['root-dir'] ?? '.',
        ], $extra);
    }

    public function get(string $name)
    {
        return $this->options[$name] ?? null;
    }

    public function expandTargetDir(string $target): string
    {
        return preg_replace_callback('{%(.+?)%}', function ($matches) {
            $option = str_replace('_', '-', strtolower($matches[1]));
            if (!isset($this->options[$option])) {
                return $matches[0];
            }

            return rtrim($this->options[$option], '/');
        }, $target);
    }

    public function shouldWriteFile(string $file, bool $overwrite): bool
    {
        if (isset($this->writtenFiles[$file])) {
            return false;
        }
        $this->writtenFiles[$file] = true;

        if (!file_exists($file)) {
            return true;
        }

        if (!$overwrite) {
            return false;
        }

        if (!filesize($file)) {
            return true;
        }

        exec('git status --short --ignored --untracked-files=all -- '.ProcessExecutor::escape($file).' 2>&1', $output, $status);

        if (0 !== $status) {
            return $this->io->askConfirmation(sprintf('Cannot determine the state of the "%s" file, overwrite anyway? [y/N] ', $file), false);
        }

        if (empty($output[0]) || preg_match('/^[ AMDRCU][ D][ \t]/', $output[0])) {
            return true;
        }

        $name = basename($file);
        $name = \strlen($output[0]) - \strlen($name) === strrpos($output[0], $name) ? substr($output[0], 3) : $name;

        return $this->io->askConfirmation(sprintf('File "%s" has uncommitted changes, overwrite? [y/N] ', $name), false);
    }

    public function toArray(): array
    {
        return $this->options;
    }
}
