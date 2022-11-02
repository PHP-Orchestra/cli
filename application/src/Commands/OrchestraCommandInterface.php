<?php

namespace PhpOrchestra\Application\Commands;

interface OrchestraCommandInterface
{
    public function setWorkingDirectory(string $folderPath): self;
    public function execute(): void;
}