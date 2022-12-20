<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

beforeEach(function () {
    // prepare folder for tests execution
    mkdir(getTestsOutputDirectory());
    $this->commandTester = new CommandTester(getApplication()->find('s:install'));
});
afterEach(function () {
    // remove folder for tests execution
    deleteDirectory(getTestsOutputDirectory());
});

test('solution:install-dependencies > runs {composer install successfully}', function() {
    // prepare Project's composer
    $projectFolder = getTestsOutputDirectory() . DIRECTORY_SEPARATOR . 'new-project';
    mkdir($projectFolder);

    $composerContent = '
    {
    "name": "php-orchestra/new-project",
    "description": "Tests layer for PHP Orchestra CLI",
    "type": "library",
    "license": "MIT"
    }
    ';
    file_put_contents($projectFolder. DIRECTORY_SEPARATOR . 'composer.json', $composerContent);

    // instanciate solution
    (new CommandTester(getApplication()->find('s:init')))->execute([
            'working-dir' => getTestsOutputDirectory(),
            '--project-scan' => 'yes'
        ]);
    // run dependencies install
    $commandResult = $this->commandTester->execute([
            'working-dir' => getTestsOutputDirectory()
    ]);
    expect($commandResult)->toBe(Command::SUCCESS);
    expect($this->commandTester->getDisplay())
    ->toBe('Solution dependencies are now installed.' . PHP_EOL);


});

test('solution:install-dependencies > fails due to invalid solution file', function() {
    // run dependencies install
    $commandResult = $this->commandTester->execute([
            'working-dir' => getTestsOutputDirectory()
    ]);
    expect($commandResult)->toBe(\Symfony\Component\Console\Command\Command::FAILURE);
    expect($this->commandTester->getDisplay())
    ->toBe('Failed to install solution dependencies. Error: ['.getTestsOutputDirectory().DIRECTORY_SEPARATOR.'orchestra.json] solution file does not exist.' . PHP_EOL);

});