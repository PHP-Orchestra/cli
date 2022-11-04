<?php

namespace PhpOrchestra\Application\Services;

use PhpOrchestra\Domain\Entity\Solution;

class SolutionService implements SolutionServiceInterface
{
    public function generate(Solution $solution)
    {
        // Prepare the content
        // >> Is it enough to do a direct parsing between object and Json?
        // write it on the json file
        file_put_contents($solution->getFullPath(), json_encode($solution));
    }

}