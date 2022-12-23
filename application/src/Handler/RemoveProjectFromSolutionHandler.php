<?php

namespace PhpOrchestra\Application\Handler;

use PhpOrchestra\Application\Adapter\SolutionAdapterInterface;
use PhpOrchestra\Domain\Entity\Project;
use PhpOrchestra\Domain\Entity\Solution;

class RemoveProjectFromSolutionHandler implements RemoveProjectFromSolutionHandlerInterface
{
    private readonly Solution $solution;
    private readonly Project $projectToRemove;
    private readonly SolutionAdapterInterface $solutionAdapter;
    private bool $isDeleteFiles = false;

    public function __construct(SolutionAdapterInterface $solutionAdapter)
    {
    
        $this->solutionAdapter = $solutionAdapter;
    }

    public function setSolution(Solution $solution): RemoveProjectFromSolutionHandler
    {
        $this->solution = $solution;
        return $this;
    }

    public function setProject(Project $project): RemoveProjectFromSolutionHandlerInterface
    {
        $this->projectToRemove = $project;
        return $this;
    }

    public function doDeleteFiles(bool $doDeleteFiles): RemoveProjectFromSolutionHandlerInterface
    {
        $this->isDeleteFiles = $doDeleteFiles;
        return $this;
    }


    public function handle(): void
    {
        $this->solution->removeProject($this->projectToRemove);
        $this->solutionAdapter->save($this->solution);

        // Todo: find a better place for this part
        if ($this->isDeleteFiles) {
            $this->deleteDirectory($this->projectToRemove->getPath());
        }
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }
    
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
    
        return rmdir($dir);
    }
}