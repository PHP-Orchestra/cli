<?php

use  PhpOrchestra\Application\Handler\InitializeSolutionHandler;
use \PhpOrchestra\Cli\Commands\Solution\InitializeCommand;
use Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Tester\CommandTester;

beforeEach(function () {
    // prepare folder for tests execution
    mkdir(getTestsOutputDirectory());
    $this->commandTester = new CommandTester(getApplication()->find('s:i'));
});
afterEach(function () {
    // remove folder for tests execution
    deleteDirectory(getTestsOutputDirectory());
});

test('solution:initialize > will ask for [working-dir] parameter', function() {
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

/*

test('$ solution init --working-dir=/a/valid/dir > when orchestra file already exists', function () {
    file_put_contents(getTestsOutputDirectory() . '/orchestra.json', '{}');

    $app = getApp();
    $app->runCommand(['minicli', 'solution', 'init', 'working-dir=' . getTestsOutputDirectory()]);
})->expectOutputRegex("/Orchestra manifest file is already created./");


test('$ solution init working-dir=/a/valid/dir > creates a standard file', function () {
    $app = getApp();
    $app->runCommand(['minicli', 'solution', 'init', 'working-dir=' . getTestsOutputDirectory()]);

    expect(is_file(getTestsOutputDirectory() . '/orchestra.json'))->toBe(true);

    $fileUnderTest = json_decode(file_get_contents(getTestsOutputDirectory() . '/orchestra.json'));

    expect($fileUnderTest->name)->toBe(Constants::ORCHESTRA_SOLUTION_NAME_DEFAULT);
    expect($fileUnderTest->version)->toBe(Constants::ORCHESTRA_SOLUTION_VERSION);
    expect($fileUnderTest->projects)->toBe([]);
});

test('$ solution init working-dir=/a/valid/dir solution-name="Feature Tests" > creates a file with custom solution name', function () {
    $app = getApp();
    $app->runCommand(['minicli', 'solution', 'init', 'working-dir=' . getTestsOutputDirectory(), 'solution-name=Feature Tests']);

    expect(is_file(getTestsOutputDirectory() . '/orchestra.json'))->toBe(true);

    $fileUnderTest = json_decode(file_get_contents(getTestsOutputDirectory() . '/orchestra.json'));

    expect($fileUnderTest->name)->toBe('Feature Tests');
    expect($fileUnderTest->version)->toBe(Constants::ORCHESTRA_SOLUTION_VERSION);
    expect($fileUnderTest->projects)->toBe([]);
});

test('$ solution init --help > displays command usage', function () {
    $app = getApp();
    $app->runCommand(['minicli', 'solution', 'init', '--help']);
})->expectOutputRegex("/Usage: solution init --working-dir=\/a\/valid\/dir/");
*/