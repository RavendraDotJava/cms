<?php
/**
 * ccapi module for Craft CMS 3.x
 *
 * A separate model for creating API abstractions in Craft. Useful for various PHP reverse proxies.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2021 Craft&Crew
 */

namespace modules\ccapimodule\twigextensions;

use modules\ccapimodule\CcapiModule;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Craft&Crew
 * @package   CcapiModule
 * @since     1.0.0
 */
class CcapiModuleTwigExtension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'CcapiModule';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('someFilter', [$this, 'someInternalFunction']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('sampleApiCall', [$this, 'sampleApiCall']),
            new TwigFunction('sampleApiToDos', [$this, 'sampleApiToDos']),
        ];
    }

    /**
     * This is a sample API interface for Twig.
     * A common pattern is to simply call the appropriate service via a function like this,
     * since most of the business logic should be maintained within the service. 
     * However, additional processing specifically related to Twig can also be handled here.
     *
     * @param null $text
     *
     * @return string
     */
    public function sampleApiCall($page = 1)
    {
        return CcapiModule::$instance->sample->getSampleData($page);
    }

    /**
     * This is a sample API interface for Twig.
     * A common pattern is to simply call the appropriate service via a function like this,
     * since most of the business logic should be maintained within the service. 
     * However, additional processing specifically related to Twig can also be handled here.
     *
     * @param null $text
     *
     * @return string
     */
    public function sampleApiToDos($page = 1)
    {
        return CcapiModule::$instance->sample->getSampleData($page);
    }    
}
