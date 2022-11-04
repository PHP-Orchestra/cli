<?php
namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
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
        if (!is_dir($this->solution->getPath())) {
            throw new InvalidArgumentException(sprintf('[%s] is not a valid directory.', $this->solution->getPath()));
        }

        if (is_file($this->solution->getFullPath())) {
            throw new InvalidArgumentException(sprintf('[%s] already exists.', $this->solution->getFullPath()));
        }

        $this->solutionService->generate($this->solution);
    }
}