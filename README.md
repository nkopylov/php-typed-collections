# nkopylov/php-collections

<!--
TODO: Make sure the following URLs are correct and working for your project.
      Then, remove these comments to display the badges, giving users a quick
      overview of your package.

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
[![Build Status][badge-build]][build]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

[badge-source]: http://img.shields.io/badge/source-nkopylov/php-collections-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/packagist/v/nkopylov/php-collections.svg?style=flat-square&label=release
[badge-license]: https://img.shields.io/packagist/l/nkopylov/php-collections.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/nkopylov/php-collections.svg?style=flat-square
[badge-build]: https://img.shields.io/travis/nkopylov/php-collections/master.svg?style=flat-square
[badge-coverage]: https://img.shields.io/coveralls/github/nkopylov/php-collections/master.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/nkopylov/php-collections.svg?style=flat-square&colorB=mediumvioletred

[source]: https://github.com/nkopylov/php-collections
[packagist]: https://packagist.org/packages/nkopylov/php-collections
[license]: https://github.com/nkopylov/php-collections/blob/master/LICENSE
[php]: https://php.net
[build]: https://travis-ci.org/nkopylov/php-collections
[coverage]: https://coveralls.io/r/nkopylov/php-collections?branch=master
[downloads]: https://packagist.org/packages/nkopylov/php-collections
-->


Generatable statically typed collections for PHP entities

This project adheres to a [code of conduct](CODE_OF_CONDUCT.md).
By participating in this project and its community, you are expected to
uphold this code.


## Installation

Install this package as a dependency using [Composer](https://getcomposer.org).

``` bash
composer require nkopylov/php-collections
```

<!--
## Usage

Provide a brief description or short example of how to use this library.
If you need to provide more detailed examples, use the `docs/` directory
and provide a link here to the documentation.

``` php
use Nkopylov\PhpCollections\Example;

$example = new Example();
echo $example->greet('fellow human');
```
-->


## Contributing

Contributions are welcome! Before contributing to this project, familiarize
yourself with [CONTRIBUTING.md](CONTRIBUTING.md).

To develop this project, you will need [PHP](https://www.php.net) 7.4 or greater,
[Composer](https://getcomposer.org), [Node.js](https://nodejs.org/), and
[Yarn](https://yarnpkg.com).

After cloning this repository locally, execute the following commands:

``` bash
cd /path/to/repository
composer install
yarn install
```

Now, you are ready to develop!

### Tooling

This project uses [Husky](https://github.com/typicode/husky) and
[lint-staged](https://github.com/okonet/lint-staged) to validate all staged
changes prior to commit.

#### Composer Commands

To see all the commands available in the project `clls` namespace for
Composer, type:

``` bash
composer list clls
```

##### Composer Command Autocompletion

If you'd like to have Composer command auto-completion, you may use
[bamarni/symfony-console-autocomplete](https://github.com/bamarni/symfony-console-autocomplete).
Install it globally with Composer:

``` bash
composer global require bamarni/symfony-console-autocomplete
```

Then, in your shell configuration file — usually `~/.bash_profile` or `~/.zshrc`,
but it could be different depending on your settings — ensure that your global
Composer `bin` directory is in your `PATH`, and evaluate the
`symfony-autocomplete` command. This will look like this:

``` bash
export PATH="$(composer config home)/vendor/bin:$PATH"
eval "$(symfony-autocomplete)"
```

Now, you can use the `tab` key to auto-complete Composer commands:

``` bash
composer clls:[TAB][TAB]
```

#### Coding Standards

This project follows a superset of [PSR-12](https://www.php-fig.org/psr/psr-12/)
coding standards, enforced by [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer).
The project PHP_CodeSniffer configuration may be found in `phpcs.xml.dist`.

lint-staged will run PHP_CodeSniffer before committing. It will attempt to fix
any errors it can, and it will reject the commit if there are any un-fixable
issues. Many issues can be fixed automatically and will be done so pre-commit.

You may lint the entire codebase using PHP_CodeSniffer with the following
commands:

``` bash
# Lint
composer clls:lint

# Lint and autofix
composer clls:lint:fix
```

#### Static Analysis

This project uses a combination of [PHPStan](https://github.com/phpstan/phpstan)
and [Psalm](https://github.com/vimeo/psalm) to provide static analysis of PHP
code. Configurations for these are in `phpstan.neon.dist` and `psalm.xml`,
respectively.

lint-staged will run PHPStan and Psalm before committing. The pre-commit hook
does not attempt to fix any static analysis errors. Instead, the commit will
fail, and you must fix the errors manually.

You may run static analysis manually across the whole codebase with the
following command:

``` bash
# Static analysis
composer clls:analyze
```

### Project Structure

This project uses [pds/skeleton](https://github.com/php-pds/skeleton) as its
base folder structure and layout.

| Name              | Description                                    |
| ------------------| ---------------------------------------------- |
| **bin/**          | Commands and scripts for this project          |
| **build/**        | Cache, logs, reports, etc. for project builds  |
| **docs/**         | Project-specific documentation                 |
| **resources/**    | Additional resources for this project          |
| **src/**          | Project library and application source code    |
| **tests/**        | Tests for this project                         |





## Copyright and License

The nkopylov/php-collections library is copyright © [Nickolay Kopylov](https://nkopylov.me/)
and licensed for use under the terms of the
BSD 3-Clause "New" or "Revised" License (BSD-3-Clause). Please see
[LICENSE](LICENSE) for more information.


