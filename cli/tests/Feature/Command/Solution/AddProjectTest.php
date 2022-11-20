<?php

use Symfony\Component\Console\Tester\CommandTester;

beforeEach(function () {
    // prepare folder for tests execution
    //mkdir(getTestsOutputDirectory());
    $this->commandTester = new CommandTester(getApplication()->find('s:add-project'));
    });

test('Hello World', function() {
    $commandResult = $this->commandTester->execute([
        'project-dir' => ''
    ]);
    expect($this->commandTester->getDisplay())
        ->toBe('hello world');
});