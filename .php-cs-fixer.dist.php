<?php

$finder = (new PhpCsFixer\Finder())
    ->in('src')
    ->in('config')
    ->ignoreVCS(true)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        'phpdoc_to_comment' => false,
        'array_syntax' => ['syntax' => 'short'],
        'no_useless_return' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ;
