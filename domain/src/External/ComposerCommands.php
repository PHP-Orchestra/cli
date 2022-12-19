<?php

namespace PhpOrchestra\Domain\External;

final class ComposerCommands
{
    public static function getComposerUpdate($workingDirectory) : string
    {
        return sprintf('composer update --working-dir=%s --quiet', $workingDirectory);
    }
}