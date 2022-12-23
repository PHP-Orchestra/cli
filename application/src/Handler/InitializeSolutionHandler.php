<?php

namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Adapter\SolutionAdapterInterface;
use PhpOrchestra\Application\Facade\ProjectScanner;
use PhpOrchestra\Domain\Entity\Solution;

class InitializeSolutionHandler implements CommandHandlerInterface
{
    private readonly Solution $solution;
    private bool $isScanforProjects = false;

    private readonly ProjectScanner $projectScanner;
    private readonly SolutionAdapterInterface $solutionAdapter;

    public function __construct(ProjectScanner $projectScanner, SolutionAdapterInterface $solutionAdapter)
    {
        $this->projectScanner = $projectScanner;
        $this->solutionAdapter = $solutionAdapter;
    }

    public function setSolution(Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    public function doProjectScan(bool $flag, int $scanDepth): self
    {
        $this->isScanforProjects = $flag;
        $this->projectScanner->setDepthLevel($scanDepth);

        return $this;
    }

    public function handle(): void
    {
        if (!is_dir($this->solution->getPath())) {
            throw new InvalidArgumentException(sprintf('[%s] is not a valid directory.', $this->solution->getPath()));
        }

        if (is_file($this->solution->getFullPath())) {
            throw new InvalidArgumentException(sprintf('[%s] already exists.', $this->solution->getFullPath()));
        }

        if ($this->isScanforProjects === true) {
            $this->solution->setProjects(
                $this->projectScanner->scan($this->solution->getPath())
            );
        }

        $this->solutionAdapter->save($this->solution);
    }
}
