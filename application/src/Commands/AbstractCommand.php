<?php

namespace PhpOrchestra\Application\Commands;

abstract class AbstractCommand
{
    protected string $workingDirectory;


    public function setWorkingDirectory(string $folderPath)
    {
        $this->workingDirectory = $folderPath;

        return $this;
    }
    public function getWorkingDirectory() :string
    {
        return $this->workingDirectory;
    }
}