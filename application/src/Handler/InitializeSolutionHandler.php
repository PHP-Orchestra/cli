<?php

namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Handler\CommandHandlerInterface;
use PhpOrchestra\Domain\Entity\Solution;

class InitializeSolutionHandler implements CommandHandlerInterface
{
    private readonly Solution $solution;
    private bool $scanforProjects = false;

    public function setSolution(Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    public function doProjectScan(bool $flag): self
    {
        $this->scanforProjects = $flag;
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

        if($this->scanforProjects) {
            // to do: add logic
        }

        file_put_contents($this->solution->getFullPath(), json_encode($this->solution->toArray(), JSON_PRETTY_PRINT));
    }
}
