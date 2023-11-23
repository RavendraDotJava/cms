<?php
/**
 * Yii Application Config
 *
 * Edit this file at your own risk!
 *
 * The array returned by this file will get merged with
 * vendor/craftcms/cms/src/config/app.php and app.[web|console].php, when
 * Craft's bootstrap script is defining the configuration for the entire
 * application.
 *
 * You can define custom modules and system components, and even override the
 * built-in system components.
 *
 * If you want to modify the application config for *only* web requests or
 * *only* console requests, create an app.web.php or app.console.php file in
 * your config/ folder, alongside this one.
 */

return [
    'modules' => [
        'ccfields-module' => [
            'class' => \modules\ccfieldsmodule\CCFieldsModule::class,
        ],
        'cc-helpers-module' => [
            'class' => \modules\cchelpersmodule\CcHelpersModule::class,
            'components' => [
                'helpers' => [
                    'class' => 'modules\cchelpersmodule\services\Helpers',
                ],
            ],
        ],
        'ccdocsmodule' => [
            'class' => \modules\ccdocsmodule\Ccdocsmodule::class,
            'components' => [
                'ccdocsmoduleService' => [
                    'class' => 'modules\ccdocsmodule\services\CcdocsmoduleService',
                ],
            ],
        ],
        'ccapi-module' => [
            'class' => \modules\ccapimodule\CcapiModule::class,
            'components' => [
                'base' => [
                    'class' => 'modules\ccapimodule\services\Base',
                ],
                'sample' => [
                    'class' => 'modules\ccapimodule\services\Sample',
                ],
                'shipbob' => [
                  'class' => 'modules\ccapimodule\services\ShipBob',
                ],
            ],
        ],
    ],
    'bootstrap' => ['ccfields-module','cc-helpers-module','ccapi-module','ccdocsmodule'],
];
