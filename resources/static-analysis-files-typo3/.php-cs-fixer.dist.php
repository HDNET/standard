<?php

use HDNET\Standard\PreSet\PhpCsFixerPreSet;
use HDNET\Standard\PreSet\PreSetInterface;

$finder = (new PhpCsFixer\Finder())
    ->in('public/typo3conf/ext/site/Classes')
    ->in('public/typo3conf/ext/site/Tests')
    ->ignoreVCS(true);

return PhpCsFixerPreSet::get(PreSetInterface::SYSTEM_TYPO3)->setFinder($finder);
