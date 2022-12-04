 <?php
 namespace PhpOrchestra\Application\Builder;

 use PhpOrchestra\Domain\Entity\Solution;

 class SolutionBuilder implements SolutionBuilderInterface
 {

   private $solutionData = [];
   private ?Solution $builtSolution;
    public function reset () : void
    {
      $this->builtSolution = null;
    }

    public function setSolutionData(array $data) : void
    {
         $this->solutionData = $data;
    }

    public function build() : Solution
    {
      $this->builtSolution = new Solution(); // TODO: Continue this builder

    }

    
 }