<?php

namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Application\Adapter\SolutionAdapterInterface;
use PhpOrchestra\Domain\Entity\Project;
use PhpOrchestra\Domain\Entity\Solution;

class RemoveProjectFromSolutionHandler implements RemoveProjectFromSolutionHandlerInterface
{
    private readonly Solution $solution;
    private readonly Project $projectToRemove;
    private readonly SolutionAdapterInterface $solutionAdapter;

    public function __construct(SolutionAdapterInterface $solutionAdapter)
    {
    
        $this->solutionAdapter = $solutionAdapter;
    }

    public function setSolution(Solution $solution): RemoveProjectFromSolutionHandler
    {
        $this->solution = $solution;
        return $this;
    }

    public function setProject(Project $project): RemoveProjectFromSolutionHandlerInterface
    {
        $this->projectToRemove = $project;
        return $this;
    }

    public function doDeleteFiles(bool $doDeleteFiles): RemoveProjectFromSolutionHandlerInterface
    {
        return $this;
    }


    public function handle(): void
    {
        $this->solution->removeProject($this->projectToRemove);
        
        $this->solutionAdapter->save($this->solution);
    }
}