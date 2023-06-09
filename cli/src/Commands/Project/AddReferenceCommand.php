<?php

namespace PhpOrchestra\Cli\Commands\Project;

use PhpOrchestra\Application\Adapter\SolutionAdapterInterface;
use PhpOrchestra\Application\Facade\ProjectScannerInterface;
use PhpOrchestra\Application\Handler\AddProjectReferenceHandlerInterface;
use PhpOrchestra\Domain\Defaults;
use PhpOrchestra\Domain\Entity\Project;
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

    private AddProjectReferenceHandlerInterface $addProjectReferenceHandler;
    private SolutionAdapterInterface $solutionAdapter;
    private ProjectScannerInterface $projectScanner;

    public function __construct(
        SolutionAdapterInterface $solutionAdapter,
        ProjectScannerInterface $projectScanner,
        AddProjectReferenceHandlerInterface $commandHandler
    ) {
        parent::__construct();

        $this->solutionAdapter = $solutionAdapter;
        $this->projectScanner = $projectScanner;
        $this->addProjectReferenceHandler = $commandHandler;
    }

    protected function configure()
    {
        $this
            ->setHelp(self::$defaultDescription)
            ->addArgument(Defaults::ORCHESTRA_PROJECT_DIR, InputArgument::REQUIRED, 'The project directory to add a new reference.')
            ->addArgument(Defaults::ORCHESTRA_REFERENCED_PROJECT_DIR, InputArgument::REQUIRED, 'The project directory to be referenced to')
            ->addArgument(Defaults::ORCHESTRA_WORKING_DIR, InputArgument::OPTIONAL, 'The directory where your solution is at.', Defaults::ORCHESTRA_SOLUTION_WORKING_DIR_DEFAULT);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDir = $input->getArgument(Defaults::ORCHESTRA_WORKING_DIR);
        $projectDir = $input->getArgument(Defaults::ORCHESTRA_PROJECT_DIR);
        $referencedProjectDir = $input->getArgument(Defaults::ORCHESTRA_REFERENCED_PROJECT_DIR);

        $solution = $this->solutionAdapter->fetch($workingDir);
        $workingProject = $this->getScannedProject($projectDir);
        $referencedProject = $this->getScannedProject($referencedProjectDir);

        $this->addProjectReferenceHandler
            ->setReferencedProject($referencedProject)
            ->setWorkingProject($workingProject)
            ->setSolution($solution)
            ->handle();

            $output->writeln(
                sprintf('<info>Project [%s] is now available in the [%s] project.</info>', $referencedProject->getName(), $workingProject->getName())
            );

        return Command::SUCCESS;
    }

    private function getScannedProject(String $projectDir) : Project
    {
        $scannedProjects = $this->projectScanner->scan($projectDir);
        if (count($scannedProjects) != 1) {
            throw new \InvalidArgumentException(
                sprintf('Invalid project directory [%s]. Please provide the specific project directory.', $projectDir)
            );
        }

        return reset($scannedProjects);
    }
}