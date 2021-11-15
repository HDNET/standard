<?php

use HDNET\Standard\PreSet\PhpCsFixerPreSet;
use HDNET\Standard\PreSet\PreSetInterface;

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return PhpCsFixerPreSet::get(PreSetInterface::SYSTEM_SYMFONY)->setFinder($finder);
