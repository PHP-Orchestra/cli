<?php

namespace PhpOrchestra\Application\Adapter;

interface AdapterInterface{
    public function fetch(string $filePath);
}