<?php

namespace PhpOrchestra\Application\Builder;

use InvalidArgumentException;
use PhpOrchestra\Domain\Entity\Solution;


class SolutionBuilder implements SolutionBuilderInterface
{

  private $solutionData = [];
  private ?string $solutionPath;
  private ?Solution $builtSolution;
  private ProjectBuilderInterface $projectBuilder;

  public function __construct(ProjectBuilderInterface $projectBuilder)
  {
    $this->projectBuilder = $projectBuilder;
  }
  public function reset(): void
  {
    $this->builtSolution = null;
  }

  public function setSolutionPath(string $path): SolutionBuilderInterface
  {
    $this->solutionPath = $path;

    return $this;
  }

  public function build(): Solution
  {

    $this->loadSolutioData();

    $this->generateSolution();

    $this->loadProjects();
    
    return $this->builtSolution;
  }

  private function loadSolutioData() : void
  {
    $solutionPath = $this->solutionPath. DIRECTORY_SEPARATOR . Solution::SOLUTION_FILE_NAME;
    if(!is_file($solutionPath)) {
      throw new InvalidArgumentException(sprintf('[%s] solution file does not exist.', $solutionPath));
    }

    $this->solutionData = json_decode(file_get_contents($solutionPath), true);
   }

   private function generateSolution() : void
   {
    $this->builtSolution = new Solution(
      $this->solutionData['name'],
      $this->solutionData['version'],
      $this->solutionPath
    );
   }

   private function loadProjects() : void
   {
    foreach($this->solutionData['projects'] as $solutionProject) {
      $this->builtSolution->addProject(
        $this->projectBuilder->setProjectData($solutionProject)
        ->build()
      );
    }
   }
}