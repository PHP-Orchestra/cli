<?php

namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Domain\Entity\Project;

interface RemoveProjectFromSolutionHandlerInterface extends CommandHandlerInterface
{
    public function setProject(Project $project): self;

    public function doDeleteFiles(bool $doDeleteFiles): self;
}