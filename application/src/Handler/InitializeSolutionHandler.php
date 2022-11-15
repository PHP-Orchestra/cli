<?php

namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Facade\ProjectScanner;
use PhpOrchestra\Domain\Entity\Solution;

class InitializeSolutionHandler implements CommandHandlerInterface
{
    private readonly Solution $solution;
    private bool $isScanforProjects = false;

    private ProjectScanner $projectScanner;

    public function __construct(ProjectScanner $projectScanner)
    {
        $this->projectScanner = $projectScanner;
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

        file_put_contents($this->solution->getFullPath(), json_encode($this->solution->toArray(), JSON_PRETTY_PRINT));
    }
}
