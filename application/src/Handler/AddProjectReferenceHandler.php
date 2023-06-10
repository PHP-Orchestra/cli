<?php

namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Adapter\ComposerAdapter;
use PhpOrchestra\Application\Adapter\SolutionAdapter;
use PhpOrchestra\Domain\Entity\Project;
use PhpOrchestra\Domain\Entity\Solution;
use PhpOrchestra\Domain\External\Composer;

// to do: find a better place for this enum

enum ProjectReferenceStrategy
{
    case PSR4;
    case Dependency; // not implemented
    case DevDependency; // not implemented
}

class AddProjectReferenceHandler implements AddProjectReferenceHandlerInterface
{
    private readonly Solution $solution;
    private Project $workingProject;
    private Project $projectToReference;
    private ProjectReferenceStrategy $referenceStrategy;
    private ComposerAdapter $composerAdapter;
    private SolutionAdapter $solutionAdapter;

    public function __construct(
        ComposerAdapter $composerAdapter,
        SolutionAdapter $solutionAdapter
    ) {
        $this->composerAdapter = $composerAdapter;
        $this->solutionAdapter = $solutionAdapter;
    }

    public function setSolution(Solution $solution): CommandHandlerInterface
    {
        $this->solution = $solution;
        return $this;
    }

    public function setWorkingProject(Project $project): self
    {
        $this->workingProject = $project;
        return $this;
    }

    public function setReferencedProject(Project $project): self
    {
        $this->projectToReference = $project;
        return $this;
    }

    public function setReferenceStrategy(ProjectReferenceStrategy $strategy): self
    {
        $this->referenceStrategy = $strategy;
        return $this;
    }

    public function handle(): void
    {
        // validate projects directories
        if ($this->workingProject->hasReferencedProject($this->projectToReference)) {
            throw new InvalidArgumentException(
                sprintf(
                    "The project [%s] has already a reference to the project [%s]",
                    $this->workingProject->getName(),
                    $this->projectToReference->getName()
                )
            );
        }

        $targetComposer = $this->composerAdapter->fetch(
            $this->workingProject->getPath()
        );

        $sourceComposer = $this->composerAdapter->fetch(
            $this->projectToReference->getPath()
        );

        if (!$targetComposer->psr4Contains($sourceComposer->getSrcPsr4Namespace())) {
            throw new InvalidArgumentException(
                sprintf(
                    "The composer project [%s] has already a PSR4 reference to the composer project [%s]",
                    $targetComposer->getSrcPsr4Namespace(),
                    $sourceComposer->getSrcPsr4Namespace()
                )
            );
        }

        $this->addComposerReference($targetComposer, $sourceComposer);

        $this->updateSolution();
    }

    private function calculateRelativePath($fromFolder, $toFolder)
    {
        // Normalize the folder paths
        $fromFolder = rtrim($fromFolder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $toFolder = rtrim($toFolder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // Convert paths to arrays of folders
        $fromFolders = explode(DIRECTORY_SEPARATOR, $fromFolder);
        $toFolders = explode(DIRECTORY_SEPARATOR, $toFolder);

        // Remove any common folders from the beginning of the paths
        while (count($fromFolders) > 0 && count($toFolders) > 0 && $fromFolders[0] === $toFolders[0]) {
            array_shift($fromFolders);
            array_shift($toFolders);
        }

        // Calculate the relative path
        $relativePath = '';

        // Add "../" for each folder in the source path
        foreach ($fromFolders as $folder) {
            if (empty($folder)) continue;
            $relativePath .= '../';
        }

        // Add the remaining folders from the target path
        $relativePath .= implode('/', $toFolders);

        // If the relative path is empty, set it to './' to represent the current directory
        if (empty($relativePath)) {
            $relativePath = './';
        }

        return $relativePath;
    }

    private function addComposerReference(Composer $targetComposer, Composer $sourceComposer)
    {
        $targetComposer->addPsr4Entry(
            $sourceComposer->getSrcPsr4Namespace(),
            $this->calculateRelativePath(
                $this->workingProject->getPath(),
                $this->projectToReference->getPath() . 'src'
            )
        );

        $this->composerAdapter->save($targetComposer);
    }

    private function updateSolution(): void
    {
        $this->workingProject->addReferencedProject(
            $this->projectToReference
        );

        // TODO: implement an update project function
        $this->solution->removeProject($this->workingProject);
        $this->solution->addProject($this->workingProject);

        $this->solutionAdapter->save($this->solution);
    }
}
