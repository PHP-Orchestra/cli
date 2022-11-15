<?php

namespace PhpOrchestra\Domain\Entity;

class Project
{
    public readonly string $name;
    public readonly string $path;

    /**
     * @param string $name
     */
    public function setName($name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $path
     */
    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
