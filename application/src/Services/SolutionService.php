<?php

namespace PhpOrchestra\Application\Services;

use InvalidArgumentException;
use PhpOrchestra\Domain\Entity\Solution;

class SolutionService implements SolutionServiceInterface
{
    public function generate(Solution $solution)
    {
        if (!is_dir($solution->getPath())) {
            throw new InvalidArgumentException(sprintf('[%s] is not a valid directory.', $solution->getPath()));
        }

        if (is_file($solution->getFullPath())) {
            throw new InvalidArgumentException(sprintf('[%s] already exists.', $solution->getFullPath()));
        }
        
        file_put_contents($solution->getFullPath(), json_encode($solution, JSON_PRETTY_PRINT));
    }

}