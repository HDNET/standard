<?php

declare(strict_types=1);

namespace HDNET\Standard\Configurator;

use RecursiveDirectoryIterator;

class CopyFromPackageConfigurator extends AbstractConfigurator
{
    public function configure($config, array $options = []): void
    {
        $this->write('Copying files from package');
        $packageDir = $this->composer->getInstallationManager()->getInstallPath($this->pluginPackage);
        $options = array_merge($this->options->toArray(), $options);

        $this->copyFiles($config, $packageDir, $options);
    }

    public function unconfigure($config): void
    {
        $this->write('Removing files from package');
        $packageDir = $this->composer->getInstallationManager()->getInstallPath($this->pluginPackage);
        $this->removeFiles($config, $packageDir, $this->options->get('root-dir'));
    }

    private function copyFiles(array $manifest, string $from, array $options): void
    {
        $to = $options['root-dir'] ?? '.';
        foreach ($manifest as $source => $target) {
            $target = $this->options->expandTargetDir($target);
            if (str_ends_with($source, '/')) {
                $this->copyDir($this->path->concatenate([$from, $source]), $this->path->concatenate([$to, $target]), $options);
            } else {
                $targetPath = $this->path->concatenate([$to, $target]);
                if (!is_dir(\dirname($targetPath))) {
                    mkdir(\dirname($targetPath), 0777, true);
                    $this->write(sprintf('  Created <fg=green>"%s"</>', $this->path->relativize(\dirname($targetPath))));
                }

                $this->copyFile($this->path->concatenate([$from, $source]), $targetPath, $options);
            }
        }
    }

    private function removeFiles(array $manifest, string $from, string $to): void
    {
        foreach ($manifest as $source => $target) {
            $target = $this->options->expandTargetDir($target);
            if (str_ends_with($source, '/')) {
                $this->removeFilesFromDir($this->path->concatenate([$from, $source]), $this->path->concatenate([$to, $target]));
            } else {
                $targetPath = $this->path->concatenate([$to, $target]);
                if (file_exists($targetPath)) {
                    @unlink($targetPath);
                    $this->write(sprintf('  Removed <fg=green>"%s"</>', $this->path->relativize($targetPath)));
                }
            }
        }
    }

    private function copyDir(string $source, string $target, array $options): void
    {
        $overwrite = $options['force'] ?? false;

        if (!is_dir($target)) {
            mkdir($target, 0777, true);
        }

        $iterator = $this->createSourceIterator($source, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $item) {
            $targetPath = $this->path->concatenate([$target, $item->getSubPathName()]);
            if ($item->isDir()) {
                if (!is_dir($targetPath)) {
                    mkdir($targetPath);
                    $this->write(sprintf('  Created <fg=green>"%s"</>', $this->path->relativize($targetPath)));
                }
            } elseif ($overwrite || !file_exists($targetPath)) {
                $this->copyFile($item, $targetPath, $options);
            }
        }
    }

    public function copyFile(string $source, string $target, array $options): void
    {
        $overwrite = $options['force'] ?? false;
        if (!$this->options->shouldWriteFile($target, $overwrite)) {
            return;
        }

        if (!file_exists($source)) {
            throw new \LogicException(sprintf('File "%s" does not exist!', $source));
        }

        file_put_contents($target, $this->options->expandTargetDir(file_get_contents($source)));
        @chmod($target, fileperms($target) | (fileperms($source) & 0111));
        $this->write(sprintf('  Created <fg=green>"%s"</>', $this->path->relativize($target)));
    }

    private function removeFilesFromDir(string $source, string $target): void
    {
        $iterator = $this->createSourceIterator($source, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $item) {
            $targetPath = $this->path->concatenate([$target, $item->getSubPathName()]);
            if ($item->isDir()) {
                // that removes the dir only if it is empty
                @rmdir($targetPath);
                $this->write(sprintf('  Removed directory <fg=green>"%s"</>', $this->path->relativize($targetPath)));
            } else {
                @unlink($targetPath);
                $this->write(sprintf('  Removed <fg=green>"%s"</>', $this->path->relativize($targetPath)));
            }
        }
    }

    private function createSourceIterator(string $source, int $mode): \RecursiveIteratorIterator
    {
        return new \RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS), $mode);
    }
}
