<?php

namespace PhpOrchestra\Domain\Entity;

class Project
{
    public readonly string $name;
    public readonly string $path;
    public array $referencedProjects = [];

    /**
     * @param string $name
     */
    public function setName($name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $path
     */
    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setReferencedProjects($projects): self
    {
        $this->referencedProjects = $projects;
        return $this;
    }

    public function getReferencedProjects(): array
    {
        return $this->referencedProjects;
    }

    public function addReferencedProject(Project $project): self
    {
        $this->referencedProjects[] = $project;
        return $this;
    }

    public function hasReferencedProject(Project $project): bool
    {
        return in_array($project, $this->referencedProjects);
    }
}
