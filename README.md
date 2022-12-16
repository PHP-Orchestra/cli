# PHP Orchestra - Project orchestration

PHP Orchestra helps you creating a decentralized PHP project

## Requirements

- PHP 8.1+ is required to run the latest version
- Composer is required.

## Compile the Phar file
PHP Orchestra is using (BOX)[https://github.com/box-project/box] for PHAR packaging.
to generate a new `orchestra.phar` file:
- Install `box` globally `composer global require humbug/box`
- Run `box compile`
- The file will be available at `./bin/orchestra.phar`