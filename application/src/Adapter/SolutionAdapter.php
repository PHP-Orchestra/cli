<?php

namespace PhpOrchestra\Application\Adapter;

use PhpOrchestra\Application\Builder\SolutionBuilderInterface;
use PhpOrchestra\Domain\Entity\Solution;

class SolutionAdapter implements SolutionAdapterInterface
{
    private SolutionBuilderInterface $solutionBuilder;

    public function __construct(SolutionBuilderInterface $solutionBuilder)
    {
        $this->solutionBuilder = $solutionBuilder;
    }
    /**
     * @var $filePath - The orchestra.json fullPath
     */
    public function fetch(string $filePath)
    {
        $this->solutionBuilder->setSolutionPath($filePath);
        $solutionEntity = $this->solutionBuilder->build();

        return $solutionEntity;


    }

    public function save(Solution $solution): void
    {
        file_put_contents($this->solution->getFullPath(), json_encode($this->solution->toArray(), JSON_PRETTY_PRINT));
    }
}