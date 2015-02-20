# solution10/devkit

This package aides in the development of the S10 packages by grouping dev tools together into one package and providing
a sweet command line tool for generating common elements of an s10 component (Makefile, folders, legal docs, phpunit etc)

Whilst this is heavily focused on the s10 components, there might be something in here useful to others! Let me know if it is!

## Installation

```sh
$ composer require --dev solution10/devkit
```

By using the --dev option you ensure that the devkit isn't pulled down when people install and use your component in production.

## Dependancies Installed

- phpUnit
- PHP Code Sniffer
- PHP Coveralls (for Travis generated coverage reports)
- APIgen

## Command line tool

The command line tool can create all of the project files you need either all in one or individually if you only want some.

The tool can create:

- Directories (src/ tests/ and docs/)
- .gitignore
- "Legal" docs (Contributing, License and readme)
- Makefile (with shortcut for generating API docs)
- PHPUnit configuration and bootstrap file
- Travis configuration file

Use `$ ./vendor/bin/s10devkit list` to see the individual commands and info on how to use them

## How to use the Devkit

On starting a new component.

```sh
$ mkdir s10-mycomponent
$ touch s10-mycomponent/composer.json
```

Then fill in composer.json with a name, description and require-dev line like so:

```json
{
    "name": "solution10/(put the name of your component here)",
    "description": "(put your component description here)",
    "minimum-stability": "stable",
    "license": "MIT",
    "authors": [
        {
            "name": "Your Name",
            "email": "Your Email"
        }
    ],
    "require-dev": {
        "solution10/devkit": "@dev"
    }
}

```

By filling in the title, description and authors, the devkit can automatically generate things like the README,
phpUnit config and Licensing info without you doing a thing.

Now all that's left to do is run composer install, and then the devkit

```sh
$ composer install
$ ./vendor/bin/s10devkit bootstrap-component
```

Instead of bootstrap-component, you could always just generate the things you want:

```sh
$ ./vendor/bin/s10devkit makefile && ./vendor/bin/s10devkit gitignore
```

To see all of the available generators, simply list:

```sh
$ ./vendor/bin/s10devkit
```

## The Travis Config file

By default the Travis file is setup to run phpunit and phpcs but obviously you can change it to do whatever you want!

## Authors

- Alex Gisby <alex@solution10.com>
