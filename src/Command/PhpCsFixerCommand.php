<?php

declare(strict_types=1);

namespace HDNET\Standard\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PhpCsFixerCommand extends BaseCommand
{
    protected static $defaultName = 'hdnet:php-cs-fixer';

    protected function configure(): void
    {
        $this->setDescription('Execute PHP CS Fixer with the right configuration');
        $this->addOption('continuous-integration', 'ci', InputOption::VALUE_NONE, 'Execution for CI context');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Executing command. tbd.');

        // ...

        return 0;
    }
}
