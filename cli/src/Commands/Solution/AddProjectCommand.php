<?php

namespace PhpOrchestra\Cli\Commands\Solution;

use PhpOrchestra\Application\Adapter\AdapterInterface;
use PhpOrchestra\Application\Adapter\SolutionAdapter;
use PhpOrchestra\Application\Handler\AddProjectToSolutionHandler;
use PhpOrchestra\Application\Handler\CommandHandlerInterface;
use PhpOrchestra\Cli\Defaults;
use PhpOrchestra\Domain\Entity\Solution;
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
    private readonly AddProjectToSolutionHandler $addProjectHandler;
    private readonly AdapterInterface $solutionAdapter;

    protected static $defaultDescription = 'Adds a project to an existent solution';

    public function __construct(
        CommandHandlerInterface $commandHandler,
        AdapterInterface $solutionAdapter
        )
    {
        parent::__construct();
       $this->addProjectHandler = $commandHandler;
       $this->solutionAdapter = $solutionAdapter; 
    }

    protected function configure()
    {
        $this
            ->setHelp(self::$defaultDescription)
            ->addArgument(Defaults::ORCHESTRA_PROJECT_DIR, InputArgument::REQUIRED, 'The directory where your project is at.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectDir = $input->getArgument(Defaults::ORCHESTRA_PROJECT_DIR);
        
        try {
            $solution = $this->solutionAdapter->fetch(
                sprintf('%s/orchestra.json', Defaults::ORCHESTRA_SOLUTION_WORKING_DIR_DEFAULT)
            );
            $this->addProjectHandler
            ->setSolution($solution);

        } catch (\Exception $ex) {
            $output->writeln(
                sprintf('<error>Failed to add project to the solution file. Error: %s</error>', $ex->getMessage())
            );
            return Command::FAILURE;
        }
                
        return Command::SUCCESS;
    }
}