<?php

namespace PhpOrchestra\Cli\Commands\Project;

use PhpOrchestra\Domain\Defaults;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'project:add-reference',
    description: 'Adds the reference of a project into another project'
)]
class AddReferenceCommand extends Command
{
    protected static $defaultDescription = 'Adds a project to an existent solution';

    public function __construct() {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setHelp(self::$defaultDescription)
            ->addArgument(Defaults::ORCHESTRA_PROJECT_DIR, InputArgument::REQUIRED, 'The project directory to add a new reference.')
            ->addArgument(Defaults::ORCHESTRA_PROJECT_DIR, InputArgument::REQUIRED, 'The project directory to be referenced to')
            ->addArgument(Defaults::ORCHESTRA_WORKING_DIR, InputArgument::OPTIONAL, 'The directory where your solution is at.', Defaults::ORCHESTRA_SOLUTION_WORKING_DIR_DEFAULT);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return Command::SUCCESS;
    }
}