<?php
namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Domain\Entity\Project;
use PhpOrchestra\Domain\Entity\Solution;

class AddProjectReferenceHandler implements AddProjectRederenceHandlerInterface
{
    private readonly Solution $solution;
    private Project $workingProject;
    private Project $projectToReference;

    public function setSolution(Solution $solution): CommandHandlerInterface
    {
        $this->solution = $solution;
        return $this;
    }

    public function setWorkingProject(Project $project): AddProjectRederenceHandlerInterface
    {
        $this->workingProject = $project;
        return $this;
        
    }

    public function setReferencedProject(Project $project): AddProjectRederenceHandlerInterface
    {
        $this->projectToReference = $project;
        return $this;
    }

    public function handle(): void
    {
        // validate projects directories
        

        // validate project to add the reference, has it or not

        // do the composer management
        // 1. Add folder path as repository
        // 2. Add dependency
        
    }
}