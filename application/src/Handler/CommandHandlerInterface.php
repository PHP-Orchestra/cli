<?php

namespace PhpOrchestra\Application\Handler;

interface CommandHandlerInterface
{
    public function handle() : void;
}