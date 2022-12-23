<?php

namespace PhpOrchestra\Application\Adapter;

use PhpOrchestra\Domain\Entity\Solution;

interface SolutionAdapterInterface extends AdapterInterface
{
    public function save(Solution $solution): void;
}
