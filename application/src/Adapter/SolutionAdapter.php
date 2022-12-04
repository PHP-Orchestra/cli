<?php

namespace PhpOrchestra\Application\Adapter;

use InvalidArgumentException;
use PhpOrchestra\Application\Builder\SolutionBuilderInterface;
use PhpOrchestra\Domain\Entity\Solution;

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
        $this->solutionBuilder->setSolutionData(json_decode(file_get_contents($filePath), true));
        $solutionEntity = $this->solutionBuilder->build();

        return $solutionEntity;


    }
}