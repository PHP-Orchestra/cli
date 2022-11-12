<?php

namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Handler\CommandHandlerInterface;
use PhpOrchestra\Domain\Entity\Project;
use PhpOrchestra\Domain\Entity\Solution;

class InitializeSolutionHandler implements CommandHandlerInterface
{
    private readonly Solution $solution;
    private bool $scanForProjects = false;
    private int $scanForProjectsDepth = 0;

    public function setSolution(Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    public function doProjectScan(bool $flag): self
    {
        $this->scanForProjects = $flag;
        return $this;
    }

    public function setProjectScanDirectoryDepth(int $depth = 0) : self
    {
        $this->scanForProjectsDepth = $depth;

        return $this;
    }

    public function handle(): void
    {
        if (!is_dir($this->solution->getPath())) {
            throw new InvalidArgumentException(sprintf('[%s] is not a valid directory.', $this->solution->getPath()));
        }

        if (is_file($this->solution->getFullPath())) {
            throw new InvalidArgumentException(sprintf('[%s] already exists.', $this->solution->getFullPath()));
        }

        if ($this->scanForProjects) {
            // to do: add logic
        $this->setProjectScanDirectoryDepth(1);
           $projects = $this->findProjects($this->solution->getPath());
            var_dump($projects);
            die('== END SCAN PROJECTS ==');
        }

        file_put_contents($this->solution->getFullPath(), json_encode($this->solution->toArray(), JSON_PRETTY_PRINT));
    }

    /**
     * Finding projects is about searching here a composer.json file is in.
     * This function should find all the projects starting from the orchestra.json file directory
     */
    private function findProjects(string $baseDir, int $depthLevel = 0)
    {
        $excludedDirectories = ['.', '..', 'vendor', '.git', '.vscode', '.idea'];
        $projectsFound = [];

        if ($this->scanForProjectsDepth >= $depthLevel) {

            $allFiles = scandir($baseDir);

            foreach ($allFiles as $childDir) {
                $currentDirectory = sprintf('%s%s%s', $baseDir, DIRECTORY_SEPARATOR, $childDir);

                if (is_dir($currentDirectory) && !in_array($childDir, $excludedDirectories)) {
                    echo 'checking '.$currentDirectory . PHP_EOL;
                    if ($this->hasComposerFile($currentDirectory)) {
                        // create Project entity and return
                        $project = new Project();
                        $project->setName($childDir)->setPath($currentDirectory);
                        $projectsFound[] = $project;


                    } else {
                        $projectsFound = array_merge($projectsFound, $this->findProjects($currentDirectory, ++$depthLevel));
                    }

                }
            }
        }

        return $projectsFound;
    }

    private function hasComposerFile($path): bool
{
    return is_file(sprintf('%s%scomposer.json', $path, DIRECTORY_SEPARATOR));
}
}
