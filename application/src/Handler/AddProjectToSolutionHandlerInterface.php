<?php

namespace PhpOrchestra\Application\Handler;

interface AddProjectToSolutionHandlerInterface extends CommandHandlerInterface
{
    public function setProjectWorkingDir(string $path):self;
}