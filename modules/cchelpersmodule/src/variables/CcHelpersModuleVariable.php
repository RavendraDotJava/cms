<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A simple module designed to contain custom logic for extending Craft.
 * Variables are often used to provide an interface for calling module logic
 * from within Craft templates.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\cchelpersmodule\variables;

use modules\cchelpersmodule\CcHelpersModule;

use Craft;

/**
 * CC Helpers Variable
 *
 * Craft allows modules to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.ccHelpersModule }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Craft&Crew
 * @package   CcHelpersModule
 * @since     1.0.0
 */
class CcHelpersModuleVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Method: setRandomString()
     * 
     * This is a simple method that provides a variable that can be accessed via Twig templates,
     * allowing us to generate a random string for use within the templates. It is also meant
     * as a simple example of how to make 
     *
     * From any Twig template, call it like this:
     *
     *     {{ craft.ccHelpersModule.getRandomString }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.ccHelpersModule.getRandomString(length) }}
     *
     * @param number $length - the desired length of the random string
     * @return string
     */
    public function getRandomString($length = 10) {
        return CcHelpersModule::$instance->helpers->setRandomString($length);
    }

}
