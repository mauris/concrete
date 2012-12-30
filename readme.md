#Packfire Concrete

>PHAR compiler for PHP-CLI applications 

##What is Packfire Concrete?

Concrete is a easy to use [Composer library](https://packagist.org/packages/packfire/concrete) and CLI tool that helps developers to compile their PHP projects into PHAR binaries for distribution. 

##Usage

There are two ways of using Packfire Concrete: as a Composer library or through a CLI tool.

###Usage - Composer Library

You can use Packfire Concrete by adding the following [`packfire/concrete`](https://packagist.org/packages/packfire/concrete) into your `composer.json` file like this:

    {
        "require":{
            "packfire/concrete": ">=1.1.*"
        },
    }

Then install your dependencies by following the [Composer installation](http://getcomposer.org/doc/00-intro.md) command:

    $ php composer.phar install

After which, you may create a `Compiler` class that extends from `\Packfire\Concrete\Compiler` and you may write your build script within the protected overriding method `compile()`. To build your PHAR binary, write a script to run the `build()` method of your `Compiler` class.

###Usage - CLI Tool

Packfire Concrete uses `concrete.json` to compile itself into `concrete.phar` by running:

    $ php bin/concrete

To help Packfire Concrete understand how to compile your project into a PHAR binary, provide the `concrete.json` file in the root directory:

    {
		"output": "torch.phar",
		"stub": "res/stub.php",
		"build":[
			{
				"processor": "\\Packfire\\Concrete\\Processor\\License",
				"build":[
					"license"
				]
			},
			{
				"processor": "\\Packfire\\Concrete\\Processor\\StripWhiteSpace",
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

Packfire Concrete is released open source under the BSD 3-Clause License. See the `license` file in repository for details.