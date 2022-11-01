<?php
namespace PhpOrchestra\Application\Services;

use PhpOrchestra\Domain\Entity\Solution;

interface SolutionServiceInterface
{
    public function generate(Solution $solution);
}