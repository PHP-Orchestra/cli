<?php

namespace PhpOrchestra\Domain\External;

class Composer
{

    private ?string $name;
    private ?string $description;
    private ?string $type;

    public function load(array $data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'] ?? '';
        $this->type = $data['type'] ?? '' ;
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

}