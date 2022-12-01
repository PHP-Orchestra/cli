<?php

namespace PhpOrchestra\Application\Adapter;

use InvalidArgumentException;

class SolutionAdapter implements AdapterInterface
{
    /**
     * @var $filePath - The orchestra.json fullPath
     */
    public function fetch(string $filePath)
    {
        if (!is_file($filePath)) {
            throw new InvalidArgumentException(sprintf('[%s] solution file does not exist.', $filePath));
        }

    }
}