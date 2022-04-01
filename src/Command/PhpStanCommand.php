<?php

declare(strict_types=1);

namespace HDNET\Standard\Command\Hdnet;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhpStanCommand extends BaseCommand
{
    protected static $defaultName = 'hdnet:php-stan';

    protected function configure(): void
    {
        $this->setDescription('Execute PHP Stan with the right configuration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Executing command. tbd.');

        // ...

        return 0;
    }
}
