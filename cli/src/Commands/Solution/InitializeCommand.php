<?php

namespace PhpOrchestra\Cli\Commands\Solution;

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
    private readonly OrchestraCommandInterface $generateSolutionCommand;
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
        /**
         * New logic, considering each layer
         */
        $workingDir = $input->getArgument('working-dir');

        try {
            $this->generateSolutionCommand
                //->setWorkingDirectory($workingDir)
                ->execute();
            $output->writeln(sprintf('<info>Orchestra solution file created at: %s</info>', $workingDir));
        } catch (\Exception $ex) {
            $output->writeln(
                sprintf('<error>Failed to create Orchestra solution file. Error: %s</error>', $ex->getMessage())
            );
            return Command::FAILURE;
        }

        return Command::INVALID;
        /*$workingDir = $input->getArgument('working-dir');

        if (!is_dir($workingDir)) {
            $output->writeln(sprintf('<error>[%s] is not a valid directory</error>', $workingDir));
            return Command::FAILURE;
        }

        $orchestraFile = sprintf('%s/%s',$workingDir, 'orchestra.json');

        if (is_file($orchestraFile)) {
            $output->writeln(sprintf('<error>[%s] already exists.</error>', $orchestraFile));
            return Command::FAILURE;
        }

        // $output->writeln(sprintf('<info>Creating %s file</info>', $orchestraFile));
        //TODO: Add logic to create the file 
        return Command::SUCCESS;
        */
    }
}
