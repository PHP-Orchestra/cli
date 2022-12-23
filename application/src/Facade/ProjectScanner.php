<?php

namespace PhpOrchestra\Application\Facade;

use PhpOrchestra\Application\Adapter\ComposerAdapter;
use PhpOrchestra\Domain\Entity\Project;
use PhpOrchestra\Domain\External\Composer;

class ProjectScanner implements ProjectScannerInterface
{
    private const EXCLUDED_DIRECTORIES = ['.', '..', 'vendor', '.git', '.vscode', '.idea'];
    private int $depthLevel = 0;
    private ComposerAdapter $composerAdapter;

    public function __construct(ComposerAdapter $adapter){
        $this->composerAdapter = $adapter;
    }

    /**
    * Finding projects is about searching where a composer.json file is in.
    * This function should find all the projects starting from the orchestra.json file directory.
    * At the same point, this is a recursive function, so be aware of the returning point.
    */
    public function scan(string $baseDir, int $depthLevel = 0) : array
    {
        $projectsFound = [];

        // scan at $baseDir directories
        if ($this->depthLevel >= $depthLevel) {
            $allFiles = scandir($baseDir);

            foreach ($allFiles as $directoryItem) {
                $currentDirectory = str_replace(['//', '\\', '/\\'], '/', sprintf('%s/%s', $baseDir, $directoryItem));

                if (is_dir($currentDirectory) && !in_array($directoryItem, self::EXCLUDED_DIRECTORIES)) {
                    if ($this->hasComposerFile($currentDirectory)) {
                        $project = $this->createProject($currentDirectory);
                        $projectsFound[] = $project;
                    } else {
                        $projectsFound = array_merge($projectsFound, $this->scan($currentDirectory, ++$depthLevel));
                    }
                }
            }
        }

        // scan the $baseDir
        if ($this->hasComposerFile($baseDir)) {
            $projectsFound[] = $this->createProject($baseDir);
        }

        return $projectsFound;
    }

    /**
     * @param int $depthLevel
     */
    public function setDepthLevel(int $depthLevel): ProjectScannerInterface
    {
        $this->depthLevel = $depthLevel;

        return $this;
    }

    private function hasComposerFile($path): bool
    {
        return is_file($path . DIRECTORY_SEPARATOR . Composer::FILENAME);
    }

    private function createProject($composerFilePath)
    {
        $composerEntity = $this->composerAdapter->fetch($composerFilePath);
                        
        // create Project entity and return
        $project = (new Project())
        ->setName($composerEntity->getName())
        ->setPath($composerFilePath);

        return $project;
    }
}
