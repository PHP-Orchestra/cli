<?php

use  PhpOrchestra\Application\Handler\InitializeSolutionHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

beforeEach(function () {
    // prepare folder for tests execution
    mkdir(getTestsOutputDirectory());
    $this->commandTester = new CommandTester(getApplication()->find('s:i'));
});
afterEach(function () {
    // remove folder for tests execution
    deleteDirectory(getTestsOutputDirectory());
});

test('solution:initialize > will ask for [working-dir] parameter', function () {
    $commandResult = $this->commandTester->execute([
        'working-dir' => ''
    ]);

    expect($commandResult)->toBe(Command::FAILURE);
    expect($this->commandTester->getDisplay())
    ->toBe('Failed to create Orchestra solution file. Error: [] is not a valid directory.' . PHP_EOL);
});

test('solution:initialize > with invalid working-dir shows an error', function () {
    $commandResult = $this->commandTester->execute([
        'working-dir' => 'invalid-dir'
    ]);

    expect($commandResult)->toBe(Command::FAILURE);
    expect($this->commandTester->getDisplay())
    ->toBe('Failed to create Orchestra solution file. Error: [invalid-dir] is not a valid directory.' . PHP_EOL);
});

test('solution:initialize /a/valid/dir > when orchestra file already exists', function () {
    file_put_contents(getTestsOutputDirectory() . '/orchestra.json', '{}');
    $commandResult = $this->commandTester->execute([
           'working-dir' => getTestsOutputDirectory()
       ]);

    expect($commandResult)->toBe(Command::FAILURE);
    expect($this->commandTester->getDisplay())
    ->toContain('already exists.');
});

test('solution:initialize /a/valid/dir > creates a standard file', function () {
    $commandResult = $this->commandTester->execute([
        'working-dir' => getTestsOutputDirectory()
    ]);

    expect($commandResult)->toBe(Command::SUCCESS);
    expect($this->commandTester->getDisplay())
    ->toBe('Orchestra solution file created at: '.getTestsOutputDirectory() . PHP_EOL);
    expect(is_file(getTestsOutputDirectory() . DIRECTORY_SEPARATOR .'orchestra.json'))->toBe(true);

    $fileUnderTest = json_decode(file_get_contents(getTestsOutputDirectory() . '/orchestra.json'));

    expect($fileUnderTest->name)->toBe(\PhpOrchestra\Cli\Defaults::ORCHESTRA_SOLUTION_NAME_DEFAULT);
    expect($fileUnderTest->version)->toBe(\PhpOrchestra\Cli\Defaults::ORCHESTRA_SOLUTION_VERSION);
    expect($fileUnderTest->projects)->toBe([]);
});

test('solution:initialize /a/valid/dir --solution-name="test solution" > creates a standard file', function () {
    $commandResult = $this->commandTester->execute([
        'working-dir' => getTestsOutputDirectory(),
        '--solution-name' => 'test solution'
    ]);

    expect($commandResult)->toBe(Command::SUCCESS);
    expect($this->commandTester->getDisplay())
    ->toBe('Orchestra solution file created at: '.getTestsOutputDirectory() . PHP_EOL);
    expect(is_file(getTestsOutputDirectory() . DIRECTORY_SEPARATOR .'orchestra.json'))->toBe(true);

    $fileUnderTest = json_decode(file_get_contents(getTestsOutputDirectory() . '/orchestra.json'));

    expect($fileUnderTest->name)->toBe('test solution');
    expect($fileUnderTest->version)->toBe(\PhpOrchestra\Cli\Defaults::ORCHESTRA_SOLUTION_VERSION);
    expect($fileUnderTest->projects)->toBe([]);
});

test('solution:initialize /a/valid/dir --project-scan > creates a standard file with projects', function () {
    //prepare project folder
    $projectFolder = sprintf('%s/project', getTestsOutputDirectory());
    mkdir($projectFolder);
    file_put_contents(sprintf('%s/composer.json', $projectFolder), '{"name": "project"}');

    $commandResult = $this->commandTester->execute([
        'working-dir' => getTestsOutputDirectory(),
        '--project-scan' => 'yes',
    '--solution-name' => 'test solution'
    ]);
    expect($commandResult)->toBe(Command::SUCCESS);
    expect($this->commandTester->getDisplay())
    ->toBe('Orchestra solution file created at: '.getTestsOutputDirectory() . PHP_EOL);
    expect(is_file(getTestsOutputDirectory() . DIRECTORY_SEPARATOR .'orchestra.json'))->toBe(true);

    $fileUnderTest = json_decode(file_get_contents(getTestsOutputDirectory() . '/orchestra.json'));
    expect(count($fileUnderTest->projects))->toBe(1);

    $firstProject = $fileUnderTest->projects[0];

    
});
