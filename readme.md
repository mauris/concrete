#Concrete

>Rock-solid PHAR compiler for PHP

##What is Concrete?

Concrete is a simple CLI tool that helps you to compile your PHP application into PHAR binary for distribution.

##Usage

There are two ways of using Concrete: as a Composer library or as a command line interface (CLI) tool.

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

###Usage - CLI Tool

Concrete uses `concrete.json` to compile itself into `concrete.phar` by running:

    $ php bin/concrete

Concrete uses information found in the `concrete.json` file of the project directory to build the PHAR binary. A sample configuration file may look like this:

    {
		"output": "torch.phar",
		"stub": "res/stub.php",
		"build":[
			{
				"processor": "\\Concrete\\Processor\\License",
				"build":[
					"license"
				]
			},
			{
				"processor": "\\Concrete\\Processor\\StripWhiteSpace",
				"build":[
					"bin",
					"src",
					"vendor"
				]
			}
		]
	}

Afterwhich, you can run the following command with the `concrete.phar` binary available:

    $ php concrete.phar

##License

Concrete is released open source under the BSD 3-Clause License. See the `license` file in repository for details.
