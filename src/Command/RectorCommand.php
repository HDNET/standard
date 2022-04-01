<?php

declare(strict_types=1);

namespace HDNET\Standard\Command\Hdnet;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RectorCommand extends BaseCommand
{
    protected static $defaultName = 'hdnet:rector';

    protected function configure(): void
    {
        $this->setDescription('Execute Rector with the right configuration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Executing command. tbd.');

        // ...

        return 0;
    }
}
