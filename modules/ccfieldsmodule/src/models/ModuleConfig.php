<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A simple module designed to contain custom logic for extending Craft.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\ccfieldsmodule\models;

use modules\ccfieldsmodule\CCFieldsModule;

use Craft;
use craft\base\Element;

/**
 * PadlModuleModel Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Craft&Crew
 * @package   PadlModule
 * @since     1.0.0
 */
class ModuleConfig
{

    public function __construct()
    {

        $config = Craft::$app->getConfig()->getConfigFromFile('custom/modules');

        foreach ( $this->config as $groupKey => $group ) {

          if ( isset($config[$groupKey]) ) {

            if ( is_array($config[$groupKey]) ) {

              foreach ( $group as $key => $opt ) {
                if ( isset($config[$groupKey][$key]) ) {
                  $this->config[$groupKey][$key] = $config[$groupKey][$key];
                }
              }

            } else {
              $this->config[$groupKey] = $config[$groupKey];
            }

          }

        }

    }


    /**
     * @var string
     *
     * @since 1.0.0
     *
     * This variable is registered with asset object by the _construct() method.
     * This allows our methods to process the data in conjuction with the configrations
     * that are registered to our object.
     */
    public $config = [

      // Module Field Options
      // These are the options that are available for the module config field.
      'options' => [
        'backgrounds' => [],
        'padding' => [],
        'decorations' => [],
        'overflow' => [],
      ],

      // Module Field Classes
      'values' => [
        'backgrounds' => [],
        'padding' => [],
        'overflow' => [],
        'custom' => [],
      ],

      // Module Defaults
      'modules' => [
        'DEFAULT' => [
          'paddingClass' => '',
          'backgroundClass' => '',
        ]
      ],

      'overlap' => 'bottom',

    ];
}
