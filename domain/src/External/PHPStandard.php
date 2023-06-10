<?php

namespace PhpOrchestra\Domain\External;

abstract class PHPStandard
{
    public static function getNamespace(): String
    {
        return __NAMESPACE__;
    }
}
