<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A configuration model specifically for gathering configuration for components.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\cchelpersmodule\models;

use modules\cchelpersmodule\CcHelpersModule;

use Craft;
use craft\base\Element;

/**
 * ComponentsConfig Model
 *
 * The configuration model basically takes the component confiugration file and
 * converts applies it to this model's $config variable.
 *
 * @author    Craft&Crew
 * @package   PadlModule
 * @since     1.0.0
 */
class CustomConfig
{

    public function __construct($config)
    {
        $path = 'custom/' . $config;
        $this->config = Craft::$app->getConfig()->getConfigFromFile($path);
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
    public $config = [];
}
