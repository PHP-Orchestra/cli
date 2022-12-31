<?php

namespace PhpOrchestra\Domain\Entity;

class Project
{
    public readonly string $name;
    public readonly string $path;
    public readonly array $dependencies;

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

    public function getDependencies() : array
    {
        return $this->dependencies;
    }

    public function addDependency(Project $project): self
    {
        if (!$this->hasDependency($project)) {
            $this->dependencies[] = $project;
        }

        return $this;
    }

    private function hasDependency(Project $project) : bool
    {
        foreach ($this->dependencies as $existentProject) {
            if ($existentProject->getName() === $project->getName()) {
                return true;
            }
        }
        return false;
    }
}
