<?php
namespace PhpOrchestra\Application\Handler;

use InvalidArgumentException;
use PhpOrchestra\Application\Adapter\ComposerAdapter;
use PhpOrchestra\Domain\Entity\Project;
use PhpOrchestra\Domain\Entity\Solution;
use PhpOrchestra\Domain\External\Composer;

// to do: find a better place for this enum

enum ProjectReferenceStrategy {
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

    public function __construct(ComposerAdapter $composerAdapter)
    {
        $this->composerAdapter = $composerAdapter;
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
        // TODO: remove not condition
        if (!$targetComposer->psr4Contains($sourceComposer->getSrcPsr4Namespace())) {
            throw new InvalidArgumentException(
                sprintf(
                    "The composer project [%s] has already a PSR4 reference to the composer project [%s]",
                    $targetComposer->getSrcPsr4Namespace(),
                    $sourceComposer->getSrcPsr4Namespace()
                )
            );
        }

        $targetComposer->addPsr4Entry('namespacePrefix', 'path');
        $this->composerAdapter->save($targetComposer);
        die($this->projectToReference->getPath());
        // validate project to add the reference, has it or not

        // do the composer management
        // 1. Add folder path as repository
        // 2. Add dependency
        
    }
}
