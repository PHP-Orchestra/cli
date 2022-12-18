<?php

namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Domain\Entity\Solution;

interface CommandHandlerInterface
{
    public function handle(): void;

    public function setSolution(Solution $solution): self;
}
