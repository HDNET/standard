<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PHP74Migration' => true,
        //'@PHP74Migration:risky' => true,
        '@PHP80Migration' => true,
        //'@PHP80Migration:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        '@PSR12' => true,
        '@PSR12:risky' => true,
        'full_opening_tag' => true,
        'phpdoc_order' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'static'],
        # @todo add more rules
        #'@Symfony:risky' => true,
        #'ordered_traits' => false,
        #'self_accessor' => false,
        #'native_function_invocation' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setCacheFile('.php-cs-fixer.cache') // forward compatibility with 3.x line
    ;
