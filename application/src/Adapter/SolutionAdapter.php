<?php

namespace PhpOrchestra\Application\Adapter;

use InvalidArgumentException;
use PhpOrchestra\Application\Builder\SolutionBuilderInterface;

class SolutionAdapter implements AdapterInterface
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
}