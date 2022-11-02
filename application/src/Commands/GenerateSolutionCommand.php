<?php

namespace PhpOrchestra\Application\Commands;

use InvalidArgumentException;
use PhpOrchestra\Application\Services\SolutionServiceInterface;
use PhpOrchestra\Domain\Entity\Solution;

class GenerateSolutionCommand extends AbstractCommand
{
    private readonly SolutionServiceInterface $solutionService;

    public function __construct(SolutionServiceInterface $solutionService)
    {
        $this->solutionService = $solutionService;
    }
    public function execute(): void
    {
        if (!is_dir($this->getWorkingDirectory())) {
            throw new InvalidArgumentException(sprintf('[%s] is not a valid directory.', $this->getWorkingDirectory()));
        }

        $orchestraFile = sprintf('%s/%s', $this->getWorkingDirectory(), 'orchestra.json');

        if (is_file($orchestraFile)) {
            throw new \Exception(sprintf('[%s] already exists.', $orchestraFile));
        }

        // To do: Replace this file generation
        file_put_contents($orchestraFile, json_encode(new Solution('solution', '1.0', $orchestraFile)));
    }

}