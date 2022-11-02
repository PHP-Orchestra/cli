<?php

namespace PhpOrchestra\Application\Commands;

abstract class AbstractCommand implements OrchestraCommandInterface
{
    protected string $workingDirectory;


    public function setWorkingDirectory(string $folderPath): self
    {
        $this->workingDirectory = $folderPath;

        return $this;
    }
    public function getWorkingDirectory() :string
    {
        return $this->workingDirectory;
    }
}