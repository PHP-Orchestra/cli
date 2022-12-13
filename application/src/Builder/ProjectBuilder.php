<?php 
namespace PhpOrchestra\Application\Builder;

use PhpOrchestra\Domain\Entity\Project;

class ProjectBuilder implements ProjectBuilderInterface
{
    private Project $builtProject;
    private array $projectData = [];

    public function reset(): void
    {
        $this->builtProject = null;
    }

    public function setProjectData(array $data) : ProjectBuilderInterface
    {
        $this->projectData = $data;
        return $this;
    }

    public function build() : Project
    {
        $this->generateFromProjectData();

        return $this->builtProject;
    }

    private function generateFromProjectData() : void
    {
        $this->builtProject = new Project();
        $this->builtProject
        ->setName($this->projectData['name'])
        ->setPath($this->projectData['path']);
    }
}