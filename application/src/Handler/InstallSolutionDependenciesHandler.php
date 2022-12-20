<?php

namespace PhpOrchestra\Application\Handler;

use Exception;
use PhpOrchestra\Domain\Entity\Solution;
use PhpOrchestra\Domain\External\ComposerCommands;

class InstallSolutionDependenciesHandler implements InstallSolutionDependenciesHandlerInterface
{
    private Solution $solution;

    public function setSolution(Solution $solution): InstallSolutionDependenciesHandlerInterface
    {
        $this->solution = $solution;

        return $this;
    }
    public function handle(): void
    {
        foreach($this->solution->getProjects() as $project) {
            $result = false;
            $output = [];
            exec(ComposerCommands::getComposerUpdate($project->getPath()), $output, $result);
            
            if ($result) {
                throw new Exception(
                    sprintf("The process failed at the project [%s]. Check manually what might be causing this.", $project->getName())
                );
            }
        }
    }
}