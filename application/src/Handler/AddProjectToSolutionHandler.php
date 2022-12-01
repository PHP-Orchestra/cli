<?php
namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Facade\ProjectScannerInterface;
use PhpOrchestra\Domain\Entity\Solution;

class AddProjectToSolutionHandler implements CommandHandlerInterface
{
    private readonly Solution $solution;

    private ProjectScannerInterface $projectScanner;

    public function __construct(ProjectScannerInterface $projectScanner)
    {
        $this->projectScanner = $projectScanner;
    }

    public function setSolution(Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    public function handle(): void
    {
        if (!is_file($this->solution->getFullPath())) {
            throw new InvalidArgumentException(sprintf('[%s] solution file does not exist.', $this->solution->getFullPath()));
            
        }
    }
}