<?php

namespace PhpOrchestra\Cli\Commands\Project;

use PhpOrchestra\Domain\Defaults;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'project:dependency',
    description: 'Sets a dependency between projects.'
    )]
class AddProjectDependencyCommand extends Command
{
    protected static $defaultDescription = 'Sets a dependency between projects.';
    public function __construct()
    {
        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setHelp(self::$defaultDescription)
            ->addArgument(Defaults::ORCHESTRA_PROJECT_DIR, InputArgument::REQUIRED, 'The directory where your project is at.')
            ->addArgument(Defaults::ORCHESTRA_PROJECT_DIR_DEPENDENCY,InputArgument::REQUIRED, 'The directory where the dependency project is at.')
            ->addArgument(Defaults::ORCHESTRA_WORKING_DIR, InputArgument::OPTIONAL, 'The directory where your solution is at.', Defaults::ORCHESTRA_SOLUTION_WORKING_DIR_DEFAULT)
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDir = $input->getArgument(Defaults::ORCHESTRA_WORKING_DIR);
        $projectDir = $input->getArgument(Defaults::ORCHESTRA_PROJECT_DIR);
        $projectDependencyDir = $input->getArgument(Defaults::ORCHESTRA_PROJECT_DIR_DEPENDENCY);

        try {
            // TODO: Add handler usage
        } catch (\Exception $ex) {
            $output->writeln(
                    sprintf('<error>Failed to add project to the solution file. Error: %s</error>', $ex->getMessage())
            );
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}