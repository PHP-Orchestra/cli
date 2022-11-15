<?php

namespace PhpOrchestra\Cli\Commands\Solution;

use PhpOrchestra\Cli\Defaults;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'solution:add-project',
    description: 'Adds a project to an existent solution'
    )]
class AddProjectCommand extends Command
{
    protected static $defaultDescription = 'Initialize a new Solution file.';

    protected function configure()
    {
        $this
            ->setHelp(self::$defaultDescription)
            ->addArgument(Defaults::ORCHESTRA_PROJECT_DIR, InputArgument::REQUIRED, 'The directory where your project is at.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        die('hello world');
    }
}