<?php
namespace PhpOrchestra\Application\Builder;

use PhpOrchestra\Domain\Entity\Project;

interface ProjectBuilderInterface
{
    public function reset() : void;
    public function setProjectData(array $data): self;
    public function build(): Project;
}