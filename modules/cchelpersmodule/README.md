# CC Helpers module for Craft CMS 3.x

A simple module designed to contain custom logic for extending Craft.

## Requirements

This module requires Craft CMS 3.0.0-RC1 or later.

## Installation

To install the module, follow these instructions.

First, you'll need to add the contents of the `app.php` file to your `config/app.php` (or just copy it there if it does not exist). This ensures that your module will get loaded for each request. The file might look something like this:
```
return [
    'modules' => [
        'cc-helpers-module' => [
            'class' => \modules\cchelpersmodule\CcHelpersModule::class,
            'components' => [
                'helpers' => [
                    'class' => 'modules\cchelpersmodule\services\Helpers',
                ],
            ],
        ],
    ],
    'bootstrap' => ['cc-helpers-module'],
];
```
You'll also need to make sure that you add the following to your project's `composer.json` file so that Composer can find your module:

    "autoload": {
        "psr-4": {
          "modules\\cchelpersmodule\\": "modules/cchelpersmodule/src/"
        }
    },

After you have added this, you will need to do:

    composer dump-autoload
 
 …from the project’s root directory, to rebuild the Composer autoload map. This will happen automatically any time you do a `composer install` or `composer update` as well.

## CC Helpers Overview

-Insert text here-

## Using CC Helpers

-Insert text here-

## CC Helpers Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [Craft&Crew](https://craftandcrew.ca/)
