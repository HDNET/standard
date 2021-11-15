<?php

declare(strict_types=1);

namespace HDNET\Standard\PreSet;

use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Ssch\TYPO3Rector\Set\Typo3SetList;

class RectorPreSet
{
    public static function load($containerConfigurator, $system): void
    {
        if (\is_callable([$containerConfigurator, 'import'])) {
            return;
        }

        // @todo get project information
        $containerConfigurator->import(SetList::CODE_QUALITY);
        $containerConfigurator->import(SymfonySetList::SYMFONY_44);
        $containerConfigurator->import(SymfonySetList::SYMFONY_50);
        $containerConfigurator->import(SymfonySetList::SYMFONY_CODE_QUALITY);

        if (PreSetInterface::SYSTEM_TYPO3 === $system) {
            $containerConfigurator->import(Typo3SetList::TYPO3_76);
            $containerConfigurator->import(Typo3SetList::TCA_76);
            $containerConfigurator->import(Typo3SetList::TYPO3_87);
            $containerConfigurator->import(Typo3SetList::TCA_87);
            $containerConfigurator->import(Typo3SetList::TYPO3_95);
            $containerConfigurator->import(Typo3SetList::TYPO3_104);
            $containerConfigurator->import(Typo3SetList::TCA_104);
            $containerConfigurator->import(Typo3SetList::TYPO3_11);
        }

        // Doctrine
        /*
        if (false) {
            // $containerConfigurator->import(DoctrineSetList::DOCTRINE_CODE_QUALITY);
            // $containerConfigurator->import(DoctrineSetList::DOCTRINE_DBAL_211);
            // $containerConfigurator->import(DoctrineSetList::DOCTRINE_REPOSITORY_AS_SERVICE);
        }
        */

        // PHP Unit
        /*
        if (false) {
            $containerConfigurator->import(PHPUnitSetList::PHPUNIT_91);
            $containerConfigurator->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);
            $containerConfigurator->import(PHPUnitSetList::PHPUNIT_EXCEPTION);
            $containerConfigurator->import(PHPUnitSetList::PHPUNIT_MOCK);
            $containerConfigurator->import(PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD);
            $containerConfigurator->import(PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER);
        }
        */

        $containerConfigurator->import(SetList::TYPE_DECLARATION_STRICT);

        $containerConfigurator->import(LevelSetList::UP_TO_PHP_80);
    }
}
