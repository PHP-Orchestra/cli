<?php

namespace PhpOrchestra\Application\Commands;

use PhpOrchestra\Application\Services\SolutionServiceInterface;

class GenerateSolutionCommand extends AbstractCommand implements CommandInterface
{
    private readonly SolutionServiceInterface $solutionService;

    public function __construct(SolutionServiceInterface $solutionService)
    {
        $this->solutionService = $solutionService;
    }
    public function execute(): void
    {
        
    }
}