<?php

namespace PhpOrchestra\Cli\Commands\Solution;

use PhpOrchestra\Application\Commands\GenerateSolutionCommand;
use PhpOrchestra\Application\Commands\OrchestraCommandInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'solution:initialize',
    description: 'Initialize a new Solution file.'
    )]
class InitializeCommand extends Command
{
    private readonly GenerateSolutionCommand $generateSolutionCommand;
    protected static $defaultDescription = 'Initialize a new Solution file.';

    public function __construct(OrchestraCommandInterface $generateSolutionCommand)
    {
        parent::__construct();
        
        $this->generateSolutionCommand = $generateSolutionCommand;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('Initialize a new Solution file')
            ->addArgument('working-dir', InputArgument::REQUIRED, 'The directory where Orchestra will be looking to.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $workingDir = $input->getArgument('working-dir');

        try {
            $this->generateSolutionCommand
                ->setWorkingDirectory($workingDir)
                ->execute();
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
