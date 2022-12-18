<?php

namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Domain\Entity\Solution;

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
        
    }
}