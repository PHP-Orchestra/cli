<?php

namespace PhpOrchestra\Application\Adapter;

use InvalidArgumentException;
use PhpOrchestra\Domain\Entity\Solution;

class SolutionAdapter implements AdapterInterface
{
    /**
     * @var $filePath - The orchestra.json fullPath
     */
    public function fetch(string $filePath)
    {
        if (!str_ends_with($filePath, 'orchestra.json')) {
            $filePath = $filePath. DIRECTORY_SEPARATOR . 'orchestra.json';
        }

        if (!is_file($filePath)) {
            throw new InvalidArgumentException(sprintf('[%s] solution file does not exist.', $filePath));
        }

        $solutionData = json_decode(file_get_contents($filePath), true);

        if (null === $solutionData['name']) {
            throw new \Exception(sprintf('Solution file [%s] has no name attribute', $filePath));
        }

        $solutionEntity = new Solution();
        $solutionEntity->load($solutionData);

        return $solutionEntity;


    }
}