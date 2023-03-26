<?php

namespace PhpOrchestra\Domain\External;

class PSR4 extends PHPStandard
{
    private readonly String $namespacePrefix;
    private readonly String $path;

    public function __construct(String $namespacePrefix, String $path)
    {
        $this->namespacePrefix = $namespacePrefix;
        $this->path = $path;
    }

    public function getNamespacePrefix(): String
    {
        return $this->namespacePrefix;
    }

    public function getPath(): String
    {
        return $this->path;
    }
}
