<?php

namespace PhpOrchestra\Application\Facade;

use PhpOrchestra\Domain\Entity\Project;

class ProjectScanner
{
    private const EXCLUDED_DIRECTORIES = ['.', '..', 'vendor', '.git', '.vscode', '.idea'];
    private int $depthLevel = 0;

    /**
    * Finding projects is about searching where a composer.json file is in.
    * This function should find all the projects starting from the orchestra.json file directory.
    * At the same point, this is a recursive function, so be aware of the returning point.
    */
    public function scan(string $baseDir, int $depthLevel = 0)
    {
        $projectsFound = [];

        if ($this->depthLevel >= $depthLevel) {
            $allFiles = scandir($baseDir);

            foreach ($allFiles as $directoryItem) {
                $currentDirectory = str_replace(['//', '\\', '/\\'], '/', sprintf('%s/%s', $baseDir, $directoryItem));

                if (is_dir($currentDirectory) && !in_array($directoryItem, self::EXCLUDED_DIRECTORIES)) {
                    if ($this->hasComposerFile($currentDirectory)) {
                        // create Project entity and return
                        $project = (new Project())
                        ->setName($directoryItem)
                        ->setPath($currentDirectory);
                        $projectsFound[] = $project;
                    } else {
                        $projectsFound = array_merge($projectsFound, $this->scan($currentDirectory, ++$depthLevel));
                    }
                }
            }
        }

        return $projectsFound;
    }

    /**
     * @param int $depthLevel
     */
    public function setDepthLevel(int $depthLevel): self
    {
        $this->depthLevel = $depthLevel;

        return $this;
    }

    private function hasComposerFile($path): bool
    {
        return is_file(sprintf('%s%scomposer.json', $path, DIRECTORY_SEPARATOR));
    }
}
