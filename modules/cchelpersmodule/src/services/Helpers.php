<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * This helper modules file contains the module's Helpers class.
 * This class includes a number of public methods, which are
 * intended to function as helpers to drive the extended
 * functionality that this module introduces to Craft.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\cchelpersmodule\services;

use modules\cchelpersmodule\CcHelpersModule;
use modules\cchelpersmodule\models\CustomConfig;
use modules\cchelpersmodule\models\ImagePlaceholder;
use modules\cchelpersmodule\models\ModuleBlock;

/** Connect to the Module Field type */
use modules\ccfieldsmodule\models\ModuleConfig;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use craft\helpers\Json;
use craft\helpers\StringHelper;
use cebe\markdown\Markdown;
use nystudio107\typogrify\services\TypogrifyService as Typogrify;

/**
 * Helpers Service
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Craft&Crew
 * @package   CcHelpersModule
 * @since     1.0.0
 */
class Helpers extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Method: setRandomString()
     *
     * This is a simple method that generates and returns a random string of a length
     * provided to the function. It is based on the accepted answer to this StackOverflow question:
     * https://stackoverflow.com/questions/4356289/php-random-string-generator
     *
     * It is also meant as a simple (but often useful) example of how to create helper functions
     * for use within this module.
     *
     * From any other plugin/module file, call it like this:
     *
     *     CcHelpersModule::$instance->helpers->setRandomString()
     *
     * @return mixed
     */
    public function setRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /**
     * Method: forkTemplatePath()
     *
     * This function takes a requested template path and then checks to see if a custom version
     * of the template exists for a specific site. It does this by appending the following to the
     * template path:
     *
     *     _sites/%siteHandle%/$path
     *
     * By default, the %siteHandle% token is the handle of the site. This can be customized within
     * the general.php config file, which can be useful for setting the same path for multiple sites
     * (multiple localizations within a site group, for instance).
     *
     * From any other plugin/module file, call it like this:
     *
     *     CcHelpersModule::$instance->helpers->forkTemplatePath()
     *
     * However, this function should really only be called from the |siteInclude filter.
     *
     * @return mixed
     */
    public function forkTemplatePath($template)
    {
        $site = Craft::$app->getSites()->currentSite;
        $siteHandle = $site->handle;
        if ( isset(Craft::$app->config->general->ccSiteIncludePaths) ) {
            if ( isset(Craft::$app->config->general->ccSiteIncludePaths[$siteHandle]) ) {
                $siteHandle = Craft::$app->config->general->ccSiteIncludePaths[$siteHandle];
            }
        }
        $templatePath = Craft::getAlias('@templates');
        $sitePath = '/_sites/' . $siteHandle . '/' . $template;
        return file_exists($templatePath . $sitePath) ? $sitePath : $template;
    }


    /**
     * Method: getDummyImage()
     *
     * This is a simple function that instantiates a copy of the ImagePlaceholder class,
     * defines the custom url, then returns the class object for use in templates.
     *
     * From any other plugin/module file, call it like this:
     *
     *     CcHelpersModule::$instance->helpers->forkTemplatePath()
     *
     * However, this function should really only be called from the dummyImage() Twig function.
     *
     * @return mixed
     */
    public function getDummyImage($url)
    {
        $image = new ImagePlaceholder();
        $image->url = $url;
        return $image;
    }

    public function getWireframeImage(int $width = 64, int $height = 64)
    {

        $rectFill = '#D8DFFF';
        $rectStroke = '#4660FF';
        $rectWidth = $width - 2;
        $rectHeight = $height - 2;

        $iconstroke = '#9DAAFF';
        $iconX = ($width/2) - 16;
        $iconY = ($height/2) - 16;

        $svg = '';
        $svg .= '<?xml version="1.0" encoding="utf-8"?>';
        $svg .= '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '" style="enable-background:new 0 0 ' . $width . ' ' . $height . ';" xml:space="preserve">';
        $svg .= '<style type="text/css">';
        $svg .= '	.iconGroup{transform:translate(' . $iconX . 'px,' . $iconY . 'px);}';
        $svg .= '	.icon{fill:none;stroke:' . $iconstroke . ';stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}';
        $svg .= '</style>';
        $svg .= '<g><rect x="1" y="1" width="' . $rectWidth . '" height="' . $rectHeight . '" rx="6" fill="' . $rectFill . '" stroke-width="1" stroke="' . $rectStroke . '"/></g>';
        $svg .= '<g class="iconGroup"><path class="icon" d="M2.5,32h27.1c1.4,0,2.5-1.1,2.5-2.5V2.5C32,1.1,30.9,0,29.5,0H2.5C1.1,0,0,1.1,0,2.5v27.1 C0,30.9,1.1,32,2.5,32z"/><path class="icon" d="M21.5,14.8c2.4,0,4.3-1.9,4.3-4.3c0-2.4-1.9-4.3-4.3-4.3c-2.4,0-4.3,1.9-4.3,4.3 C17.2,12.8,19.1,14.8,21.5,14.8z"/><path class="icon" d="M21.9,32c-0.8-4.2-3.1-8-6.4-10.7c-3.3-2.7-7.5-4.1-11.8-4c-1.2,0-2.5,0.1-3.7,0.3"/><path class="icon" d="M32,23.2c-2-0.7-4.1-1-6.1-1c-2.6,0-5.3,0.5-7.7,1.6"/></g>';
        $svg .= '</svg>';

        return $svg;


    }


    /**
     * Method: getComponentClasses()
     *
     * This method fetches the class sets from the components.php configuration file, then loops through
     * the DEFAULT for a specific component, building the class by combining each item in the associative
     * array. If it finds a matching entry in an alternate style for the given component, it will use that
     * entry instead. This is what allows for the simple, substitution-based customization.
     *
     * The method also accepts additional custom classes that can be appended to the end of the class list.
     *
     * @param string $type - the component type being requested
     * @param string $style - optional - the compoent style
     * @param string $class - optional - additional compoent classes to be passed in
     *
     * @return string - returns the list of classes
     */
    public function getComponentClasses($type, $style, $c)
    {

        if ( ! isset($GLOBALS['components::config']) ) {
            $GLOBALS['components::config'] = new CustomConfig('components');
        }
        $components = $GLOBALS['components::config'];
        $class = 'c-' . StringHelper::toKebabCase($type);
        if ( (!empty($style) && strtoupper($style) !== 'DEFAULT' ) ) {
            $class .= ' v-' . StringHelper::toKebabCase($style);
        }

        if ( isset($components->config[$type]) ) {
            if ( $components->config[$type]['DEFAULT'] ) {

                foreach ( $components->config[$type]['DEFAULT'] as $key => $fragment ) {

                    if ( isset($components->config[$type][$style][$key]) ) {
                        $class = trim($class . ' ' . $components->config[$type][$style][$key]);
                    } else {
                        $class = trim($class . ' ' . $fragment);
                    }

                }

            }
        }

        $class .= ' ' . $c;

        return trim($class);
    }


    /**
     * Method: getModuleLayout()
     *
     * This method is built to fetch the configration settings for a given feed component.
     * It basically fetches the feeds.php config file and uses both the config values and
     * the current entry object to determine all the values required to render out the
     * field component. This includes setting any filters that should be made available
     * to the feed.
     *
     * @param object $block - the matrix block for a given module
     * @param boolean $dataOnly - optional - determines whether only the module data should
     *   be included:
     *    - if true, the module incrementor will not be advanced and the module data will
     *      not be stored into the $GLOBALS['_modules:previous'] variable.
     *
     * @return object - returns the list of classes
     */
    public function getModuleLayout($block, $dataOnly = false)
    {
        $config = new ModuleConfig();
        $module = new ModuleBlock($block, $config->config, $dataOnly);
        return $module;
    }


    /**
     * Method: getFeedConfig()
     *
     * This method is built to fetch the configration settings for a given feed component.
     * It basically fetches the feeds.php config file and uses both the config values and
     * the current entry object to determine all the values required to render out the
     * field component. This includes setting any filters that should be made available
     * to the feed.
     *
     * @param string $feed - the component type being requested
     * @param object $entry - optional - the compoent style
     *
     * @return array - returns the list of classes
     */
    public function getFeedConfig($feed, $entry)
    {

        if ( ! isset($GLOBALS['feed::config']) ) {
            $GLOBALS['feed::config'] = new CustomConfig('feeds');
        }
        $feedConfig = $GLOBALS['feed::config']->config;
        $config = (isset($feedConfig[$feed])) ? $feedConfig[$feed] : false;
        $config['entry'] = $entry->id;

        // Define the filters from the entry.
        // If we're not using entry-based filters, the logic here can change
        // to set the filters accoridng to the project requirements.
        if ( isset($config['filters']) ) {

            $filters = [];

            if ( is_string($config['filters']) ) {
                $filterName = $config['filters'];
                $fields = $entry->$filterName;
                foreach ( $fields->all() as $filter ) {
                    array_push($filters, $this->buildFiltersObject($filter, $config));
                }
            }

        }

        $config['filters'] = $filters;
        $config['filtersTitle'] = 'Filter Content';

        $filtersJs = 'false';
        if ( ! empty($config['filters']) ) {
            $inc = 0;
            $filtersJs = '{';
            foreach ( $config['filters'] as $filter ) {
                if ( $inc > 0 ) {
                    $filtersJs .= ',';
                }
                $filtersJs .= $filter['id'] . ':[';
                if ( isset(Craft::$app->request->queryParams[$filter['id']]) ) {
                    $x = 0;
                    $filterSplit = explode(':', Craft::$app->request->queryParams[$filter['id']]);
                    foreach ( $filterSplit as $f ) {
                        if ( $x > 0 ) {
                            $filtersJs .= ',';
                        }
                        $filtersJs .= "'" . $f . "'";
                        $x += 1;
                    }
                }
                $filtersJs .= ']';
                $inc += 1;
            }
            $filtersJs .= '}';
        }
        $config['filtersJs'] = $filtersJs;

        return $config;

    }


    /**
     * Method: buildFiltersObject()
     *
     * This method is used to build out an array of filter data pairs for each of
     * the indivdual options within a particular filters group. This effectively
     * allows us to normalize the data structure that is provided to the TWIG
     * component template for consistent rendering.
     *
     * @param object|boolean $filter - the filter object
     * @param array|boolean $confg - optional - the feed config, which provides the
     *   sections that are available for this feed.
     *
     * @return array - returns the array containing information about the filter,
     *   including the list of data pairs.
     */
    public static function buildFiltersObject($filter = false, $config = false)
    {

        // Define the base associative array, which will contain basic information
        // about the filter along with the individual data pairs.
        $array = array(
           'id' =>  $filter->filterId,
           'type' => $filter->type->handle,
           'heading' => $filter->heading,
           'filters' => array()
        );

        // There are several different filter types.
        // This switch statement provides instructions for handling each type.
        switch ( $filter->type->handle ) {

            // Sections Type
            case "sections":
                if ( isset($config['sections']) ) {
                    if ( count($config['sections']) > 1 ) {
                        foreach ( $config['sections'] as $sectionHandle ) {
                            $section = Craft::$app->sections->getSectionByHandle($sectionHandle);
                            array_push($array['filters'], array(
                                'label' => $section->name,
                                'filter' => $section->handle,
                            ));
                        }
                    } else {
                        $array['filters'] = false;
                    }
                }
                break;

            // Relations Type
            case "relations":
                foreach ( $filter->relations->all() as $relation ) {
                    array_push($array['filters'], array(
                        'label' => $relation->title,
                        'filter' => $relation->slug . '.' . $relation->id,
                    ));
                }
                break;

            // Years Type
            case "years":
                $entries = Entry::find()->section($config['sections'])->all();
                $years = [];
                foreach ( $entries as $entry ) {
                    $date = $entry->postDate->format('Y');
                    if ( ! in_array($date, $years) ) {
                        array_push($years, $date);
                    }
                }
                foreach ( $years as $year ) {
                    array_push($array['filters'], array(
                        'label' => $year,
                        'filter' => $year,
                    ));
                }
                break;
        }

        return $array;
    }


    /**
     * Method: getModuleLayout()
     *
     * This method is used to generate the query object that gets passed into the
     * craft.entries() method. There's quite a bit of logic involved in getting
     * this set up, and it's cleaner and more effecient to pass this off to a PHP
     * helper function rather than trying to handle it all through TWIG templates.
     *
     * @param string $config - the config for the particular feed type
     * @param boolean|array $exclude - optional - if included, it should be an array
     *   of entry ids to exclude from the query
     *
     * @return object - returns object that gets used for the query.
     */
    public static function feedQueryParams($config, $exclude = false)
    {

        // Define the base query object, along with basic defaults.
        $query = [
            'section' => $config['sections'],
            'limit' => $config['count'],
            'orderBy' => 'postDate DESC',
            'id' => ['not', $config['entry']]
        ];

        // Here was have to accomodate for the different filters that are available to this feed.
        foreach ( $config['filters'] as $filter ) {
            if(isset(Craft::$app->request->queryParams[$filter['id']])) {

                // There are several different filter types.
                // This switch statement provides instructions for handling each type.
                switch ( $filter['type'] ) {

                    // Sections type
                    case 'sections':
                        $sections = [];
                        $sectionSplit = explode(':', Craft::$app->request->queryParams[$filter['id']]);

                        foreach ( $sectionSplit as $filter ) {
                            if ( in_array($filter, $config['sections']) ) {
                                array_push($sections, $filter);
                            }
                        }

                        if ( ! empty($sections) ) {
                            $query['section'] = $sections;
                        }
                        break;

                    // Relations Type
                    case 'relations':
                        $entries = explode(':', Craft::$app->request->queryParams[$filter['id']]);
                        $relationsIds = [];
                        foreach ( $entries as $entry ) {
                            $entrySplit = explode('.', $entry);
                            if ( ! empty($entrySplit[1])) {
                                array_push($relationsIds, $entrySplit[1]);
                            }
                        }
                        $query['relatedTo'] = Entry::find()->id($relationsIds)->all();
                        break;

                    // Years type
                    case 'years':
                        $years = explode(':', Craft::$app->request->queryParams[$filter['id']]);
                        $year = $years[0];
                        $query['postDate'] = ['and', '>= ' . $year . '-01-01', '< ' . $year . '-12-31'];
                        break;
                }
            }
        }

        // Implement ID-based exclusions
        if ( is_array($exclude) ) {
            foreach ( $exclude as $id ) {
                array_push($query['id'], $id);
            }
        }

        return $query;
    }


    /**
     * Method: getEntrySnippet()
     *
     * This function is used to automatically generate a descriptive snippet for an entry,
     * based on a hierarchy of fields.
     *
     * From any other plugin/module file, call it like this:
     *
     *     CcHelpersModule::$instance->helpers->getEntrySnippet()
     *
     * @param object $entry - the entry object
     * @param int    $trim  - the desired length if the snippet.
     *
     * @return string - the formatted HTML snippet.
     */
    public function getEntrySnippet($entry, $trim = 160)
    {

        // Start by checking the explicit Description field, which is specifically
        // intended for this purpose...
        if ( isset($entry->description ) ) {
            if ( ! empty($entry->description) ) {
                return $this->prepareEntrySnippet($entry->description, $trim);
            }
        }

        // ... Next, check for the Intro Paragraph field, which provides a reasonable
        // fallback if Description is not set...
        if ( isset($entry->introParagraph ) ) {
            if ( ! empty($entry->introParagraph) ) {
                if ( method_exists($entry->introParagraph, 'getNodes') ) {
                    if ( count($entry->introParagraph->getNodes()) > 0 ) {
                        $intro = '';
                        foreach ( $entry->introParagraph->getNodes() as $node ) {
                            $intro .= $node->renderHtml();
                        }
                        if ( ! empty(strip_tags($intro)) ) {
                            return $this->prepareEntrySnippet($intro, $trim);
                        }
                    }
                } else {
                    return $this->prepareEntrySnippet($entry->introParagraph, $trim);
                }
            }
        }

        // ... Lastly, check if the entry has a Rich Content field. If this is present,
        // we can generate the snippet from its paragraph content.
        if ( isset($entry->richContent) ) {
            if ( method_exists($entry->richContent, 'getNodes') ) {
                if ( count($entry->richContent->getNodes()) > 0 ) {
                    $intro = '';
                    foreach ( $entry->richContent->getNodes() as $node ) {
                        $intro .= $node->renderHtml();
                    }
                    if ( ! empty(strip_tags($intro)) ) {
                        return $this->prepareEntrySnippet($intro, $trim);
                    }
                }
            }
        }

        // If we reach this point, it means that no meaningful data was provided for
        // generating a snippet, and we return an empty string.
        return '';
    }

    /**
     * Method: prepareEntrySnippet()
     *
     * This function is called by the getEntrySnippet() fuction, and is basically a helper
     * function which:
     *
     * - first leverages the Typgrify plugin to trim the snippet to the desire length
     *   without breaking in the middle of a word
     * - then returns the snippet passed through a Markdown filter.
     *
     * @param object $entry - the entry object
     * @param int    $trim  - the desired length if the snippet.
     *
     * @return string - the formatted HTML snippet.
     */
    public function prepareEntrySnippet($snippet, $trim = 160)
    {
        $parser = new Markdown();
        $typogrify = new Typogrify();
        if ( ! empty($snippet) ) {
            $parsedSnippet = $typogrify->truncateOnWord($snippet, $trim);
            return $parser->parse($parsedSnippet);
        }
        return '';
    }


}
