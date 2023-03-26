<?php

namespace PhpOrchestra\Domain;

final class Defaults
{
    // app params
    public const ORCHESTRA_SOLUTION_NAME_PARAMETER = 'solution-name';
    public const ORCHESTRA_WORKING_DIR = 'working-dir';
    public const ORCHESTRA_PROJECT_DIR = 'project-dir';
    public const ORCHESTRA_REFERENCED_PROJECT_DIR = 'referenced-project-dir';
    public const ORCHESTRA_DELETE_FILES = 'delete-files';
    public const ORCHESTRA_SCAN_FOR_PROJECTS = 'project-scan';
    public const ORCHESTRA_SCAN_FOR_PROJECTS_DEPTH = 'project-scan-depth';

    // Default values
    public const ORCHESTRA_SOLUTION_FILENAME = 'orchestra.json';
    public const ORCHESTRA_SOLUTION_NAME_DEFAULT = 'Orchestra Solution';
    public const ORCHESTRA_SOLUTION_WORKING_DIR_DEFAULT = '.';
    public const ORCHESTRA_SOLUTION_VERSION = '0.1';
}