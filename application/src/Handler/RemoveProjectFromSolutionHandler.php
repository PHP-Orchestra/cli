<?php

namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Domain\Entity\Project;
use PhpOrchestra\Domain\Entity\Solution;

class RemoveProjectFromSolutionHandler implements RemoveProjectFromSolutionHandlerInterface
{
    private readonly Solution $solution;
    private readonly Project $project;

    public function setSolution(Solution $solution): RemoveProjectFromSolutionHandler
    {
        $this->solution = $solution;
        return $this;
    }

    public function setProject(Project $project): RemoveProjectFromSolutionHandlerInterface
    {
        $this->project = $project;
        return $this;
    }

    public function handle(): void
    {
        // TODO: Implement handle() method.
    }
}