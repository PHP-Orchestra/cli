<?php

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
    
})->skip();