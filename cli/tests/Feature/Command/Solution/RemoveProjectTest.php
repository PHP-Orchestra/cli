<?php

use PhpOrchestra\Domain\Defaults;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

beforeEach(function () {
    // prepare folder for tests execution
    mkdir(getTestsOutputDirectory());
    mkdir(getTestsOutputDirectory().DIRECTORY_SEPARATOR.'project1');
    mkdir(getTestsOutputDirectory().DIRECTORY_SEPARATOR.'project2');
    $this->commandTester = new CommandTester(getApplication()->find('solution:remove-project'));

    $solutionContent = '
    {
        "name": "Orchestra Solution",
        "version": "0.1",
        "projects": [
            {
                "name": "php-orchestra\/project1",
                "path": "'.str_replace(DIRECTORY_SEPARATOR, '\\'. DIRECTORY_SEPARATOR,getTestsOutputDirectory().DIRECTORY_SEPARATOR.'project1').'"
            },
            {
                "name": "php-orchestra\/project2",
                "path": ".\/project2"
            }
        ]
    }
    ';
    file_put_contents(getTestsOutputDirectory(). DIRECTORY_SEPARATOR . Defaults::ORCHESTRA_SOLUTION_FILENAME, $solutionContent);

    $composerContent = '
    {
        "name": "php-orchestra/project1",
        "description": "Tests layer for PHP Orchestra CLI",
        "type": "library",
        "license": "MIT"
    }
    ';
    file_put_contents(getTestsOutputDirectory(). DIRECTORY_SEPARATOR . 'project1/composer.json', $composerContent);
    
});
afterEach(function () {
    // remove folder for tests execution
    deleteDirectory(getTestsOutputDirectory());
});

test('solution:remove-project > removes the project from the orchestra.json file', function() {
    //call the command to remove project1
    $commandResult = $this->commandTester->execute([
        'working-dir' => getTestsOutputDirectory(),
        'project-dir' => getTestsOutputDirectory().DIRECTORY_SEPARATOR.'project1'
    ]);

    expect($this->commandTester->getDisplay())
    ->toBe('The project [php-orchestra/project1], was removed from the solution.' . PHP_EOL);
    expect($commandResult)->toBe(Command::SUCCESS);

    $directoryExists = is_dir(getTestsOutputDirectory().DIRECTORY_SEPARATOR.'project1');
    expect($directoryExists)->toBeTrue();
});

test('solution:remove-project > removes the project from the orchestra.json file and the folder', function() {
    //call the command to remove project1
    // force --delete-files to be true
    $this->commandTester->setInputs(['yes']);
    $commandResult = $this->commandTester->execute([
        'working-dir' => getTestsOutputDirectory(),
        'project-dir' => getTestsOutputDirectory().DIRECTORY_SEPARATOR.'project1',
        '--delete-files' => 'y'
    ]);

    expect($this->commandTester->getDisplay())
    ->toContain('The project [php-orchestra/project1], was removed from the solution.' . PHP_EOL);
    expect($commandResult)->toBe(Command::SUCCESS);

    $directoryExists = is_dir(getTestsOutputDirectory().DIRECTORY_SEPARATOR.'project1');
    expect($directoryExists)->toBeFalse();
});