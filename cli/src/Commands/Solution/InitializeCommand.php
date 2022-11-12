<?php

namespace PhpOrchestra\Cli\Commands\Solution;

use PhpOrchestra\Application\Handler\CommandHandlerInterface;
use PhpOrchestra\Application\Handler\InitializeSolutionHandler;
use PhpOrchestra\Application\Facade\ProjectScanner;
use PhpOrchestra\Cli\Defaults;
use PhpOrchestra\Domain\Entity\Solution;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'solution:initialize',
    description: 'Initialize a new Solution file.'
)]
class InitializeCommand extends Command
{
    private readonly InitializeSolutionHandler $initializeSolutionHandler;
    protected static $defaultDescription = 'Initialize a new Solution file.';

    public function __construct(CommandHandlerInterface $commandHandler)
    {
        parent::__construct();

        $this->initializeSolutionHandler = $commandHandler;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('Initialize a new Solution file')
            ->addArgument(Defaults::ORCHESTRA_WORKING_DIR, InputArgument::REQUIRED, 'The directory where Orchestra will be looking to.')
            ->addOption(Defaults::ORCHESTRA_SOLUTION_NAME_PARAMETER, 's', InputOption::VALUE_OPTIONAL, 'The solution name of your project.', Defaults::ORCHESTRA_SOLUTION_NAME_DEFAULT)
            ->addOption(Defaults::ORCHESTRA_SCAN_FOR_PROJECTS, 'scan', InputOption::VALUE_NEGATABLE, 'Scan root folder for projects.', true)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $workingDir = $input->getArgument(Defaults::ORCHESTRA_WORKING_DIR);
        $solutionName = $input->getOption(Defaults::ORCHESTRA_SOLUTION_NAME_PARAMETER);
        $isProjectScan = $input->getOption(Defaults::ORCHESTRA_SCAN_FOR_PROJECTS);
        try {
            $solution = new Solution($solutionName, Defaults::ORCHESTRA_SOLUTION_VERSION, $workingDir);

            if ($isProjectScan) {
                $scanner = new ProjectScanner(0);
                $projects = $scanner->scan($solution->getPath());
                $solution->setProjects($projects);
            }

            $this->initializeSolutionHandler
            ->setSolution($solution)
            ->handle();

            $output->writeln(sprintf('<info>Orchestra solution file created at: %s</info>', $workingDir));
        } catch (\Exception $ex) {
            $output->writeln(
                sprintf('<error>Failed to create Orchestra solution file. Error: %s</error>', $ex->getMessage())
            );
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
