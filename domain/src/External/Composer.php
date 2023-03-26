<?php

namespace PhpOrchestra\Domain\External;

use PhpOrchestra\Domain\External\Composer\Repository;

class Composer
{
    public const FILENAME = 'composer.json';

    private ?string $name;
    private ?string $description;
    private ?string $type;
    private ?array $autoload = [];
    private ?array $repositories = [];

    public function load(array $data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'] ?? '';
        $this->type = $data['type'] ?? '' ;
        
        $this->parseAutoLoad($data['autoload']);
        $this->parseRepositories($data['repositories'] ?? []);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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