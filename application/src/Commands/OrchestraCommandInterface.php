<?php

namespace PhpOrchestra\Application\Commands;

interface OrchestraCommandInterface
{
    public function execute(): void;
}