<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

beforeEach(function () {
    // prepare folder for tests execution
    //mkdir(getTestsOutputDirectory());
    $this->commandTester = new CommandTester(getApplication()->find('s:add-project'));
    });

test('solution:add-project > will ask for [project-dir] parameter', function () {
    $commandResult = $this->commandTester->execute([
        'project-dir' => ''
    ]);

    expect($commandResult)->toBe(Command::FAILURE);
    expect($this->commandTester->getDisplay())
    ->toBe('Failed to add project to the solution file. Error: [./orchestra.json] solution file does not exist.' . PHP_EOL);
});

test('solution:add-project > with invalid [project-dir] parameter shows an error', function () {
    file_put_contents(getTestsOutputDirectory() . '/orchestra.json', '{}');
    $commandResult = $this->commandTester->execute([
        'project-dir' => 'invalid dir'
    ]);

    expect($commandResult)->toBe(Command::FAILURE);
    expect($this->commandTester->getDisplay())
    ->toBe('Failed to add project to the solution file. Error: [./orchestra.json] solution file does not exist.' . PHP_EOL);
});