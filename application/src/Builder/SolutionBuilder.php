<?php

namespace PhpOrchestra\Application\Builder;
use PhpOrchestra\Domain\Entity\Solution;

class SolutionBuilder implements SolutionBuilderInterface
{

  private $solutionData = [];
  private ?string $solutionPath;
  private ?Solution $builtSolution;
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

    $this->builtSolution = new Solution(
      $this->solutionData['name'],
      $this->solutionData['version'],
      $this->solutionPath
    );
    
    return $this->builtSolution;
  }

  private function loadSolutioData() : void
  {
    $this->solutionData = json_decode(file_get_contents($this->solutionPath. DIRECTORY_SEPARATOR . Solution::SOLUTION_FILE_NAME), true);
   }
}