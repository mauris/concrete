#Concrete

[![Build Status](https://travis-ci.org/mauris/concrete.svg?branch=master)](https://travis-ci.org/mauris/concrete) [![Latest Stable Version](https://poser.pugx.org/mauris/concrete/v/stable.svg)](https://packagist.org/packages/mauris/concrete) [![Total Downloads](https://poser.pugx.org/mauris/concrete/downloads.svg)](https://packagist.org/packages/mauris/concrete)

>Rock-solid PHAR compiler for PHP

##What is Concrete?

Concrete is a simple CLI tool that helps you to compile your PHP application into PHAR binary for distribution.

##Usage

There are three ways of using Concrete. Through [Composer](https://getcomposer.org/), you can install Concrete to your system hassle-free or include it as a library on your project. Alternatively, you can build Concrete into a PHAR archive and use the binary.

###Usage - Composer CLI Application

With great thanks to Composer, you can install Concrete on your machine. You must ensure that Composer is installed on your system. Run the following command to install Concrete.

    composer global require mauris/concrete

After installation is complete, you will be able to use concrete:

    concrete build

###Usage - Composer Library

You can use Concrete by adding the following [`mauris/concrete`](https://packagist.org/packages/mauris/concrete) into your `composer.json` file like this:

    {
        "require":{
            "mauris/concrete": "1.2.*"
        },
    }

Then install your dependencies by following the [Composer installation](http://getcomposer.org/doc/00-intro.md) command:

    $ php composer.phar install

After which, you may create a `Compiler` class that extends from `\Concrete\Compiler` and you may write your build script within the protected overriding method `compile()`. To build your PHAR binary, write a script to run the `build()` method of your `Compiler` class.

###Usage - PHAR Binary

You can use Concrete as a standalone PHAR binary. Either

1) Download from the [Release](https://github.com/mauris/concrete/releases) page; or,
2) Follow the instructions found in "Building Concrete" to build the `concrete.phar`.

##Building Concrete

Concrete uses `concrete.json` to compile itself into `concrete.phar` by running:

    $ php bin/concrete

Concrete will use the information found in the `concrete.json` file of the project directory to build itself.

Afterwhich, you will find the `concrete.phar` generated in the current working directory.

##License

Concrete is released open source under the *BSD 3-Clause License*. See the `LICENSE` file in repository for details.
