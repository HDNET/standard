<?php

declare(strict_types=1);

namespace HDNET\Standard\PreSet;

use PhpCsFixer\Config;

class PhpCsFixerPreSet
{
    public static function get($system): Config
    {
        $config = new Config();

        // @todo add the right rules based on project settings

        if (PreSetInterface::SYSTEM_TYPO3 === $system) {
            $config->setRules([
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
                // @todo add more rules
                //'@Symfony:risky' => true,
                //'ordered_traits' => false,
                //'self_accessor' => false,
                //'native_function_invocation' => false,
            ]);
        } elseif (PreSetInterface::SYSTEM_SYMFONY === $system) {
            $config->setRules([
                '@Symfony' => true,
                '@Symfony:risky' => true,
                '@PHP80Migration' => true,
                '@PHP80Migration:risky' => true,
                '@PHPUnit84Migration:risky' => true,
                'phpdoc_to_comment' => false,
                'array_syntax' => ['syntax' => 'short'],
                'no_useless_return' => true,
            ]);
        }

        $config->setRiskyAllowed(true);
        $config->setCacheFile('.php-cs-fixer.cache');

        return $config;
    }
}
