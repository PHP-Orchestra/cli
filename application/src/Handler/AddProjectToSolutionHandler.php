<?php
namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Facade\ProjectScannerInterface;
use PhpOrchestra\Domain\Entity\Solution;

class AddProjectToSolutionHandler implements AddProjectToSolutionHandlerInterface
{
    private readonly Solution $solution;

    private ProjectScannerInterface $projectScanner;
    private string $projectWorkingDirectory;

    public function __construct(ProjectScannerInterface $projectScanner)
    {
        $this->projectScanner = $projectScanner;
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
    }
}