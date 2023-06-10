<?php

namespace PhpOrchestra\Cli;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct(iterable $commands = [])
    {
        parent::__construct();

        foreach ($commands as $command) {
            $this->add($command);
        }
    }

    public function getName(): string
    {
        return 'PHP Orchestra CLI tool';
    }

    public function getVersion(): string
    {
        return '0.1.5';
    }
}
