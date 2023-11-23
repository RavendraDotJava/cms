<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A simple module designed to contain custom logic for extending Craft.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\ccdocsmodule\twigextensions;

use modules\ccdocsmodule\Ccdocsmodule;

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
class CcdocsmoduleTwigExtension extends AbstractExtension
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
        return 'Ccdocsmodule';
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
            new TwigFunction('docContents', [$this, 'getContents']),
            new TwigFunction('docSections', [$this, 'getSections']),
            new TwigFunction('docElements', [$this, 'getElements']),
            new TwigFunction('docEntryTypes', [$this, 'getEntryTypes']),
            new TwigFunction('docFields', [$this, 'getFieldContents']),
            new TwigFunction('docSectionDescription', [$this, 'getSectionDescription']),
            new TwigFunction('docTypeDescription', [$this, 'getTypeDescription']),
            new TwigFunction('docSeoName', [$this, 'getSeoFieldName']),
            new TwigFunction('docSeoFields', [$this, 'getSeoFieldContents']),
            new TwigFunction('docSocialProfiles', [$this, 'getSocialProfiles']),
            new TwigFunction('entryTypeDoc', [$this, 'entryTypeDoc']),
            new TwigFunction('globalDoc', [$this, 'globalDoc']),
            new TwigFunction('assetDoc', [$this, 'assetDoc']),
            new TwigFunction('getDocumentationImage', [$this, 'getDocumentationImage']),
            new TwigFunction('getAdminUrl', [$this, 'ccGetAdminUrl']),
            new TwigFunction('returnAdminUrl', [$this, 'ccReturnAdminUrl']),
        ];
    }

    /**
     * This is a simple helper function, which is designed for use as
     * an alternative to dump(), which uses the print_r() PHP command.
     * 
     * Additionally, it wraps the output in a <pre> tags for simpler
     * formatting within Twig output.
     *
     * @param null $text
     *
     * @return string
     */

    public function getContents()
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getContents();
    }

    public function getSections()
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getSectionsHtml();
    } 

    public function getElements($type = 'assets')
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getElementsHtml($type);
    }

    public function getEntryTypes($section)
    {
        $sectionBlock = Ccdocsmodule::$instance->ccdocsmoduleService->getSectionSectionArray($section);
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getTypesHtml($sectionBlock);
    }  
    
    public function getFieldContents()
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getFieldContents();
    }  

    public function getSectionDescription($section, $full = false)
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getSectionDescription($section, $full);
    }

    public function getTypeDescription($type, $full = false)
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getTypeDescription($type, $full);
    }    

    public function getSeoFieldName()
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getSeoFieldName();
    }

    public function getSeoFieldContents()
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getSeoFieldContents();
    }

    public function getSocialProfiles()
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getSocialProfiles();
    }

    public function entryTypeDoc($type = null, $warning = false, $header = 'h2')
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->entryTypeDoc($type, $warning, $header);
    }

    public function globalDoc($global, $warning = false, $header = 'h2')
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->globalDoc($global, $warning, $header);
    }

    public function assetDoc($volume, $warning = false, $header = 'h2')
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->assetDoc($volume, $warning, $header);
    }    

    public function getDocumentationImage($file, $alt = '') 
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getDocumentationImage($file, $alt);
    }

    public function ccReturnAdminUrl()
    {
        return Ccdocsmodule::$instance->ccdocsmoduleService->getAdminUrl();
    }

    public function ccGetAdminUrl()
    {
        echo Ccdocsmodule::$instance->ccdocsmoduleService->getAdminUrl();
    } 

}
