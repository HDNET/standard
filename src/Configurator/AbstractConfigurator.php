<?php

declare(strict_types=1);

namespace HDNET\Standard\Configurator;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use HDNET\Standard\Composer\Options;
use HDNET\Standard\Composer\Path;

abstract class AbstractConfigurator
{
    /**
     * @const string
     */
    public const ROOT_DIR = '.';

    /**
     * @const string
     */
    protected const NAME = 'HDNET-STANDARD';
    protected Path $path;

    public function __construct(protected Composer $composer, protected IOInterface $io, protected Options $options, protected PackageInterface $pluginPackage)
    {
        $this->path = new Path($options->get('root-dir'));
    }

    abstract public function configure($config, array $options = []);

    abstract public function unconfigure($config);

    protected function write($messages): void
    {
        if (!\is_array($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $i => $message) {
            $messages[$i] = '    '.$message;
        }
        $this->io->writeError($messages, true, IOInterface::VERBOSE);
    }

    protected function isFileMarked(string $file): bool
    {
        return is_file($file) && str_contains(file_get_contents($file), sprintf('###> %s ###', self::NAME));
    }

    protected function markData(string $data): string
    {
        return "\n".sprintf('###> %s ###%s%s%s###< %s ###%s', self::NAME, "\n", rtrim($data, "\r\n"), "\n", self::NAME, "\n");
    }

    protected function isFileXmlMarked(string $file): bool
    {
        return is_file($file) && str_contains(file_get_contents($file), sprintf('###+ %s ###', self::NAME));
    }

    protected function markXmlData(string $data): string
    {
        return "\n".sprintf('        <!-- ###+ %s ### -->%s%s%s        <!-- ###- %s ### -->%s', self::NAME, "\n", rtrim($data, "\r\n"), "\n", self::NAME, "\n");
    }

    /**
     * @return bool True if section was found and replaced
     */
    protected function updateData(string $file, string $data): bool
    {
        if (!file_exists($file)) {
            return false;
        }

        $pieces = explode("\n", trim($data));
        $startMark = trim(reset($pieces));
        $endMark = trim(end($pieces));
        $contents = file_get_contents($file);

        if (!str_contains($contents, $startMark) || !str_contains($contents, $endMark)) {
            return false;
        }

        $pattern = '/'.preg_quote($startMark, '/').'.*?'.preg_quote($endMark, '/').'/s';
        $newContents = preg_replace($pattern, trim($data), $contents);
        file_put_contents($file, $newContents);

        return true;
    }
}
