<?php
namespace PhpOrchestra\Application\Facade;

interface ProjectScannerInterface {
    public function scan(string $baseDir): array;
    public function setDepthLevel(int $depthLevel): self;
}