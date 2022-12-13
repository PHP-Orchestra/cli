<?php

namespace PhpOrchestra\Application\Builder;

use PhpOrchestra\Domain\Entity\Solution;

interface SolutionBuilderInterface
{
    public function reset() : void;
    
    public function build() : Solution;

    public function setSolutionPath(string $path) : self;
}