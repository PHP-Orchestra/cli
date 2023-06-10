<?php

namespace PhpOrchestra\Domain\External;

use PhpOrchestra\Domain\External\Composer\Repository;

class Composer
{
    public const FILENAME = 'composer.json';

    private ?string $folderPath;
    private ?array $payload = [];

    public function __construct(string $folderPath, $data)
    {
        $this->folderPath = $folderPath;
        $this->payload = $data;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->payload['name'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->payload['description'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->payload['type'];
    }

    public function getFolderPath(): ?string
    {
        return $this->folderPath;
    }

    public function psr4Contains(String $namespace) : bool
    {
        
        foreach($this->payload['autoload'][PSR4::toString()] as $entry => $path)
        {
            if ($entry == $namespace) {
                return true;
            }
        }

        return false;
    }

    public function addPsr4Entry($namespacePrefix, $folderPath)
    {
        $this->payload['autoload'][PSR4::toString()][$namespacePrefix] = $folderPath;
    }

    public function getSrcPsr4Namespace() : string
    {
        foreach($this->payload['autoload'][PSR4::toString()] as $entry => $path)
        {
            if ($path === 'src/')
            {
                return $entry;
            }
        }
        return null;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}
