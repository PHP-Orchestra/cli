<?php
namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Application\Handler\CommandHandlerInterface;
use PhpOrchestra\Application\Services\SolutionServiceInterface;
use PhpOrchestra\Domain\Entity\Solution;

class InitializeSolutionHandler implements CommandHandlerInterface
{
    private readonly Solution $solution;
    private readonly SolutionServiceInterface $solutionService;

    public function __construct(SolutionServiceInterface $solutionService)
    {
        $this->solutionService = $solutionService;
    }

    public function setSolution(Solution $solution) : self
    {
        $this->solution = $solution;

        return $this;
    }

    public function handle() : void
    {
            $this->solutionService->generate($this->solution);
    }
}