<?php

namespace PhpOrchestra\Domain\External;

use PhpOrchestra\Domain\External\Composer\Repository;

class Composer
{
    public const FILENAME = 'composer.json';

    private ?string $folderPath;
    private ?string $name;
    private ?string $description;
    private ?string $type;
    private ?array $autoload = [];
    private ?array $repositories = [];
    private ?array $payload = [];

    public string $cenas = 'coisas';

    public function __construct(?string $folderPath = null)
    {
        $this->folderPath = $folderPath;
    }

    public function load(array $data)
    {
        
       /* $this->name = $data['name'];
        $this->description = $data['description'] ?? '';
        $this->type = $data['type'] ?? '' ;
        
        $this->parseAutoLoad($data['autoload']);
        $this->parseRepositories($data['repositories'] ?? []);
        */

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
        return $this->description;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function getAutoLoad()
    {
        return $this->autoload;
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

    private function parseAutoLoad($autoloadPayload) : void
    {
        foreach($autoloadPayload as $standard => $entries) {
            // if orchestra knows how to handle it? class must exist
            $stdStrategy = sprintf('%s\\%s', PHPStandard::getNamespace(), strtoupper(str_replace('-','', $standard)));
            if (class_exists($stdStrategy)) {
                foreach($entries as $key => $value) {
                    $ob = new $stdStrategy($key, $value);

                    if (!isset($this->autoload[$stdStrategy])) {
                        $this->autoload[$stdStrategy] = [];
                    }
                    $this->autoload[$stdStrategy][] = $ob;
                }
            }
        }
    }

    private function parseRepositories($repositoriesPayload) : void
    {
        foreach($repositoriesPayload as $repository) {
            $repo = new Repository($repository['type'], $repository['url']);
            $this->repositories[] = $repo;
        }
        
    }

}