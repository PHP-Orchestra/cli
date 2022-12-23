<?php
namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Adapter\SolutionAdapterInterface;
use PhpOrchestra\Application\Facade\ProjectScannerInterface;
use PhpOrchestra\Domain\Entity\Solution;

class AddProjectToSolutionHandler implements AddProjectToSolutionHandlerInterface
{
    private readonly Solution $solution;

    private ProjectScannerInterface $projectScanner;
    private readonly SolutionAdapterInterface $solutionAdapter;
    private string $projectWorkingDirectory;

    public function __construct(ProjectScannerInterface $projectScanner, SolutionAdapterInterface $solutionAdapter)
    {
        $this->projectScanner = $projectScanner;
        $this->solutionAdapter = $solutionAdapter;
    }

    public function setProjectWorkingDir(string $path): AddProjectToSolutionHandlerInterface
    {
        $this->projectWorkingDirectory = $path;
        
        return $this;
    }

    public function setSolution(Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    public function handle(): void
    {
        if (!is_dir($this->projectWorkingDirectory)) {
            throw new InvalidArgumentException(sprintf('[%s] Project directory is not valid.', $this->projectWorkingDirectory));
            
        }
        
        foreach($this->projectScanner->scan($this->solution->getPath()) as $project) {
        $this->solution->addProject($project);
        }

        $this->solutionAdapter->save($this->solution);
    }
}