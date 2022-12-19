<?php
namespace PhpOrchestra\Cli\Commands\Solution;

use PhpOrchestra\Application\Adapter\AdapterInterface;
use PhpOrchestra\Application\Handler\CommandHandlerInterface;
use PhpOrchestra\Application\Handler\InstallSolutionDependenciesHandlerInterface;
use PhpOrchestra\Domain\Defaults;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'solution:install-dependencies',
    description: 'Initialize a new Solution file.'
)]
class InstallDependenciesCommand extends Command
{
    protected static $defaultDescription = 'Install Composer dependencies on all the projects';

    private readonly InstallSolutionDependenciesHandlerInterface $installDependenciesHandler;
    private readonly AdapterInterface $solutionAdapter;

    public function __construct(
        CommandHandlerInterface $commandHandler,
        AdapterInterface $solutionAdapter
    ) {
        parent::__construct();
        $this->installDependenciesHandler = $commandHandler;
        $this->solutionAdapter = $solutionAdapter;
    }

    protected function configure(): void
    {
        $this->setHelp(self::$defaultDescription)
        ->addArgument(Defaults::ORCHESTRA_WORKING_DIR, InputArgument::OPTIONAL, 'The directory where your solution is at.', Defaults::ORCHESTRA_SOLUTION_WORKING_DIR_DEFAULT);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workingDir = $input->getArgument(Defaults::ORCHESTRA_WORKING_DIR);

        try {
            $solution = $this->solutionAdapter->fetch($workingDir);

            $this->installDependenciesHandler
            ->setSolution($solution)
            ->handle();

            $output->writeln(sprintf('<info>Solution dependencies are now installed.</info>'));
    
        } catch (\Exception $ex) {
            $output->writeln(
                sprintf('<error>Failed to install solution dependencies. Error: %s</error>', $ex->getMessage())
            );
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}