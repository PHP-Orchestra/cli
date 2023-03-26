<?php
namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Domain\Entity\Project;

interface AddProjectReferenceHandlerInterface extends CommandHandlerInterface
{
    public function setWorkingProject(Project $project): self;
    public function setReferencedProject(Project $project): self;
    public function setReferenceStrategy(ProjectReferenceStrategy $strategy): self;
}