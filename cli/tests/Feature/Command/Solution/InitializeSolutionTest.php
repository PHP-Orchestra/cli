<?php

use  PhpOrchestra\Application\Handler\InitializeSolutionHandler;
use \PhpOrchestra\Cli\Commands\Solution\InitializeCommand;
use Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Tester\CommandTester;

beforeEach(function () {
    // prepare folder for tests execution
    mkdir(getTestsOutputDirectory());
});
afterEach(function () {
    // remove folder for tests execution
    deleteDirectory(getTestsOutputDirectory());
});

/*
test('solution:initialize > will ask for [working-dir] parameter', function() {
    $commandTester = new CommandTester(getApplication()->find('s:i'));
    $commandTester->execute([
        'working-dir' => './'
    ]);
    expect($commandTester->execute([]))->toThrow(\RuntimeException::class);



});

*/
/*
test('$ solution init > will ask for working-dir parameter', function () {
    $app = getApp();
    $app->runCommand(['minicli', 'solution', 'init']);
})->expectOutputRegex("/Missing required param \[working-dir\]/");

test('$ solution init > with invalid working-dir shows an error', function () {
    $app = getApp();
    $app->runCommand(['minicli', 'solution', 'init', 'working-dir=invalid']);
})->expectOutputRegex("/\[working-dir\] is invalid. Please provide a valid directory/");

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