<?php

namespace PhpOrchestra\Domain\Entity;

class Solution
{
    public readonly String $name;
    public readonly String $version;
    public readonly String $path;
    public array $projects;

    public const SOLUTION_FILE_NAME = 'orchestra.json';

    public function __construct(string $solutionName, string $version, string $path)
    {
        $this->name = $solutionName;
        $this->version = $version;
        $this->path = $path;
        $this->projects = [];
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

    public function getFullPath(): string
    {
        return str_replace('//', '/', sprintf('%s/%s', $this->getPath(), self::SOLUTION_FILE_NAME));
    }

    public function addProject(Project $project): void
    {
        $this->projects[] = $project;
    }

    /**
     * @param array $projects
     */
    public function setProjects($projects) : self
    {
        $this->projects = $projects;
        return $this;
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
            'projects' => $this->getProjects()
        ];
    }
}
