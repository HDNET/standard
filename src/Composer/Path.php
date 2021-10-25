<?php

declare(strict_types=1);

namespace HDNET\Standard\Composer;

class Path
{
    public function __construct(protected string $workingDirectory)
    {
    }

    public function relativize(string $absolutePath): string
    {
        $relativePath = str_replace($this->workingDirectory, '.', $absolutePath);

        return is_dir($absolutePath) ? rtrim($relativePath, '/').'/' : $relativePath;
    }

    public function concatenate(array $parts): string
    {
        $first = array_shift($parts);

        return array_reduce($parts, fn (string $initial, string $next): string => rtrim($initial, '/').'/'.ltrim($next, '/'), $first);
    }
}
