<?php

namespace PhpOrchestra\Domain\Entity;

class Solution
{
    public readonly String $name;
    public readonly String $version;
    public readonly String $path;
    public array $projects;

    public function __construct(string $solutionName, string $version, string $path)
    {
        $this->name = $solutionName;
        $this->version = $version;
        $this->path = $path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getPath(): String
    {
        return $this->path;
    }

    public function addProject(Project $project): void
    {
        $this->projects[$project->getName()] = $project;
    }

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'version' => $this->getVersion(),
        ];
    }
}