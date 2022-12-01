<?php

namespace PhpOrchestra\Application\Adapter;

use InvalidArgumentException;
use PhpOrchestra\Domain\External\Composer;

class ComposerAdapter implements AdapterInterface
{
    public function fetch(string $filePath) : Composer
    {
        if (!str_ends_with($filePath, 'composer.json')) {
            $filePath = $filePath. DIRECTORY_SEPARATOR . 'composer.json';
        }

        if (!is_file($filePath)) {
            throw new InvalidArgumentException(sprintf('Cannot fetch the composer file for file. Is the file path correct?[%s]', $filePath));
        }

        $composerData = json_decode(file_get_contents($filePath), true);

        if (null === $composerData['name']) {
            throw new \Exception(sprintf('Composer file [%s] has no name attribute', $filePath));
        }

        $composerEntity = new Composer();
        $composerEntity->load($composerData);

        return $composerEntity;
    }
}