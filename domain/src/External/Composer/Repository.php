<?php

namespace PhpOrchestra\Domain\External\Composer;

class Repository
{
    private readonly string $type;
    private readonly string $url;

    public function __construct(string $type, string $url)
    {
        $this->type = $type;
        $this->url = $url;
    }

    public function getType() : string
    {
        return $this->type;
    }

    
    public function getUrl() : string
    {
        return $this->url;
    }
}
