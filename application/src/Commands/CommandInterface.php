<?php

namespace PhpOrchestra\Application\Commands;

interface CommandInterface
{
    public function execute(): void;
}