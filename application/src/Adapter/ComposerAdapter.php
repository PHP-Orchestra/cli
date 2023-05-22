<?php

namespace PhpOrchestra\Application\Adapter;

use InvalidArgumentException;
use PhpOrchestra\Domain\Defaults;
use PhpOrchestra\Domain\External\Composer;

class ComposerAdapter implements AdapterInterface
{
    public function fetch(string $filePath) : Composer
    {
        if (!str_ends_with($filePath, Composer::FILENAME)) {
            $filePath = $filePath. DIRECTORY_SEPARATOR . Composer::FILENAME;
        }

        if (!is_file($filePath)) {
            throw new InvalidArgumentException(sprintf('Cannot fetch the composer file for file. Is the file path correct?[%s]', $filePath));
        }

        $composerData = json_decode(file_get_contents($filePath), true);

        if (null === $composerData['name']) {
            throw new \Exception(sprintf('Composer file [%s] has no name attribute', $filePath));
        }

        $composerEntity = new Composer($filePath);
        $composerEntity->load($composerData);

        return $composerEntity;
    }

    public function save(Composer $composerEntity) 
    {
        if (null === $composerEntity->getFolderPath()) {
            throw new \Exception('Composer instance is missing the folder path');
        }
        $filePath = $composerEntity->getFolderPath();
        file_put_contents($filePath, $composerEntity);
        die($composerEntity->getName());
        
    }
}