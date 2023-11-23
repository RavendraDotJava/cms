<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A simple module designed to contain custom logic for extending Craft.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\ccfieldsmodule\twigextensions;

use modules\ccfieldsmodule\CCFieldsModule;
use modules\ccfieldsmodule\services\IconService;
use modules\ccfieldsmodule\models\Heading as HeadingModule;

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
 * @package   CcHelpersModule
 * @since     1.0.0
 */
class CCFieldsModuleTwigExtension extends AbstractExtension
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
        return 'CcFieldsModule';
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
        return [];
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
            new TwigFunction('icon_sets', [$this, 'icon_sets']),
            new TwigFunction('icon_path', [$this, 'icon_path']),
            new TwigFunction('get_heading', [$this, 'get_heading']),            
        ];
    }

    /**
     * This is a simple helper function, which is designed for use as
     * an alternative to dump(), which uses the icon_sets() PHP command.
     * 
     * Additionally, it wraps the output in a <pre> tags for simpler
     * formatting within Twig output.
     *
     * @param null $text
     *
     * @return string
     */
    public function icon_sets($sets = array())
    {
        return IconService::getIconNames($sets);
    }

    public function icon_path($sets = array())
    {
        return IconService::getIconsUrl();
    }
    
    public function get_heading($heading, $attributes = [], $level = false)
    {
        if ( empty($level) ) {
            $level = $GLOBALS['currentHeading'];
        }
        return new HeadingModule([
            'heading' => $heading,
            'levels' => $level,
            'attributes' => $attributes,
        ]);
    }    

}
