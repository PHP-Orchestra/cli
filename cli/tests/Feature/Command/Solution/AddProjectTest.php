<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

beforeEach(function () {
    // prepare folder for tests execution
    mkdir(getTestsOutputDirectory());
    $this->commandTester = new CommandTester(getApplication()->find('s:add-project'));
});
afterEach(function () {
    // remove folder for tests execution
    deleteDirectory(getTestsOutputDirectory());
});

test('solution:add-project > will ask for [project-dir] parameter', function () {
    $commandResult = $this->commandTester->execute([
        'project-dir' => '',
        'working-dir' => getTestsOutputDirectory()
    ]);

    expect($commandResult)->toBe(Command::FAILURE);
    expect($this->commandTester->getDisplay())
    ->toBe('Failed to add project to the solution file. Error: ['.getTestsOutputDirectory().DIRECTORY_SEPARATOR.'orchestra.json] solution file does not exist.' . PHP_EOL);
});

test('solution:add-project > with invalid [project-dir] parameter shows an error', function () {
    file_put_contents(
        getTestsOutputDirectory() . '/orchestra.json',
        '{"name": "Orchestra Solution", "version": "0.1", "projects": []}'
    );
    $commandResult = $this->commandTester->execute([
        'project-dir' => 'invalid dir',
        'working-dir' => getTestsOutputDirectory()
    ]);

    expect($commandResult)->toBe(Command::FAILURE);
    expect($this->commandTester->getDisplay())
    ->toBe('Failed to add project to the solution file. Error: [invalid dir] Project directory is not valid.' . PHP_EOL);
});

test('solution:add-project > with valid [project-dir] but no composer file does not add project', function () {
    $orchestraSolutionFile = getTestsOutputDirectory() . '/orchestra.json';
    $solutionContent = '{"name": "Orchestra Solution", "version": "0.1", "projects": []}';
    file_put_contents(
        $orchestraSolutionFile,
        $solutionContent
    );

    $projectFolder = getTestsOutputDirectory().DIRECTORY_SEPARATOR.'project1';
    mkdir($projectFolder);

    $commandResult = $this->commandTester->execute([
        'project-dir' => $projectFolder,
        'working-dir' => getTestsOutputDirectory()
    ]);

    expect($commandResult)->toBe(Command::SUCCESS);

    $fileUnderTest = json_decode(file_get_contents(getTestsOutputDirectory() . '/orchestra.json'));

    expect($fileUnderTest->name)->toBe(\PhpOrchestra\Domain\Defaults::ORCHESTRA_SOLUTION_NAME_DEFAULT);
    expect($fileUnderTest->version)->toBe(\PhpOrchestra\Domain\Defaults::ORCHESTRA_SOLUTION_VERSION);
    expect($fileUnderTest->projects)->toBe([]);
});

test('solution:add-project > add a project to the solution projects', function () {
    // Arrange
    $solutionPath = getTestsOutputDirectory().DIRECTORY_SEPARATOR . 'orchestra.json';
    $solutionContent = '
    {
        "name": "Orchestra Solution",
        "version": "0.1",
        "projects": [
          {
            "name": "php-orchestra/existent-project",
            "path": "./existent-project-folder"
          }
        ]
      }
    ';
    file_put_contents($solutionPath, $solutionContent);
    $projectPath = getTestsOutputDirectory() . DIRECTORY_SEPARATOR . 'new-project-1';
    $projectComposerPath = $projectPath . DIRECTORY_SEPARATOR . 'composer.json';
    $projectComposerContent = '
    {
        "name": "php-orchestra/project-1",
        "description": "Test project of PHP Orchestra",
        "type": "library"
    }
    ';
    mkdir($projectPath);
    file_put_contents($projectComposerPath, $projectComposerContent);

    // act
    $commandResult = $this->commandTester->execute([
        'project-dir' => $projectPath,
        'working-dir' => getTestsOutputDirectory()
    ]);

    //assert
    expect($commandResult)->toBe(Command::SUCCESS);

    $subjectUnderTest = json_decode(file_get_contents($solutionPath));

    expect($subjectUnderTest->name)->toBe('Orchestra Solution');
    expect($subjectUnderTest->version)->toBe('0.1');
    expect(count($subjectUnderTest->projects))->toBe(2);

    expect($subjectUnderTest->projects[0]->name)->toBe('php-orchestra/existent-project');
    expect($subjectUnderTest->projects[1]->name)->toBe('php-orchestra/project-1');
});
