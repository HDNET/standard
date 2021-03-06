<?php

use HDNET\Standard\PreSet\PhpCsFixerPreSet;
use HDNET\Standard\PreSet\PreSetInterface;

$finder = (new PhpCsFixer\Finder())
    ->in('src')
    ->in('config')
    ->ignoreVCS(true);

return PhpCsFixerPreSet::get(PreSetInterface::SYSTEM_SYMFONY)->setFinder($finder);
