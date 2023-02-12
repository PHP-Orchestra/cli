<?php
namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Domain\Entity\Project;

interface AddProjectRederenceHandlerInterface extends CommandHandlerInterface
{
    public function setWorkingProject(Project $project): AddProjectRederenceHandlerInterface;
    public function setReferencedProject(Project $project): AddProjectRederenceHandlerInterface;
}