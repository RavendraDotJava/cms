<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A simple module designed to contain custom logic for extending Craft.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\ccfieldsmodule\services;

use modules\ccfieldsmodule\CCFieldsModule;

use Craft;
use craft\base\Component;
use craft\elements\Entry;

/**
 * Helpers Service
 *
 * All of your module’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other modules can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Craft&Crew
 * @package   CcHelpersModule
 * @since     1.0.0
 */
class IconService extends Component
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
    public static function getIconsSvgPath()
    {

        $publicPath = Craft::getAlias('@webroot');
        if (substr($publicPath, -1) !== '/') {
            $publicPath .= '/';
        }
        $iconsPath = $publicPath . 'ui/icons.svg';
        if ( isset(Craft::$app->config->general->ccFieldIconsSvgPath) ) {
            $iconsPath = $publicPath . Craft::$app->config->general->ccFieldIconsSvgPath;
        }
        return $iconsPath;

    }

    public static function getIconsUrl()
    {

        $iconsPath = '/ui/icons.svg';
        return $iconsPath;

    }

    public static function getIconFileValidation()
    {

        $iconValid = false;
        $iconsPath = self::getIconsSvgPath();
        if ( file_exists($iconsPath) ) {
            $iconValid = true;
        }
        return $iconValid;

    }

    public static function getIconSets()
    {

        $sets = [];
        $iconsPath = self::getIconsSvgPath();

        if ( file_exists($iconsPath) ) {

            $iconXml = file_get_contents($iconsPath);
            if ( $iconDom = simplexml_load_string( $iconXml ) ) {
                if ( ! empty($iconDom->symbol) ) {
                    foreach ( $iconDom->symbol as $symbol ) {
                        if ( isset($symbol->attributes()->iconSet) ) {
                            $iconSet = (string)$symbol->attributes()->iconSet;
                            if ( ! isset($sets[$iconSet]) ) {
                                $sets[$iconSet] = $iconSet;
                            }
                        }
                    }
                }
            }

        }

        return $sets;

    }

    public static function getIconNames($set = array())
    {

        if ( ! $GLOBALS['icons'] ) { return $set; }
        $icons = [];
        $iconsPath = self::getIconsSvgPath();
        $iconsDate = filemtime($iconsPath);
        $iconsKey = 'iconsCache';
        $cachedSet = false;

        if ( ! empty($set) ) {
            $setKey = '';
            foreach( $set as $key => $value ) {
                $setKey .= ':' . $value;
            }
            $iconsKey .= '::' . substr($setKey,1);

        }

        if ( isset($GLOBALS[$iconsKey]) ) {
            $cachedSet = $GLOBALS[$iconsKey];
            $icons = $cachedSet['icons'];
        }
        else if ( Craft::$app->cache->exists($iconsKey) ) {

            $cachedSet = Craft::$app->cache->get($iconsKey);

            if ( $iconsDate > $cachedSet['filetime'] || empty($cachedSet['icons'])) {
                $cachedSet = false;
            }
            else {
                $icons = $cachedSet['icons'];
            }

        }

        if ( empty($cachedSet) ) {
            if ( file_exists($iconsPath) ) {

                $iconXml = file_get_contents($iconsPath);
                if ( $iconDom = simplexml_load_string( $iconXml ) ) {

                    if ( ! empty($iconDom->symbol) ) {

                        $useSet = ( ! empty($set) );
                        foreach ( $iconDom->symbol as $symbol ) {

                            $pickable = true;
                            if ( $useSet ) {
                                if ( isset($symbol->attributes()->iconSet) ) {
                                    $iconSet = (string)$symbol->attributes()->iconSet;
                                    if ( ! in_array($iconSet, $set) ) {
                                        $pickable = false;
                                    }
                                }
                            }

                            if ( $pickable ) {
                                $id = (string)$symbol->attributes()->id[0];
                                $id = substr($id, 5);
                                array_push($icons, $id);
                            }

                        }

                    }

                }
            }

            $cachedSet = array(
                'filetime' => $iconsDate,
                'icons' => $icons,
            );
            Craft::$app->cache->set($iconsKey, $cachedSet, (3600 * 30));

        }

        $GLOBALS[$iconsKey] = $cachedSet;

        return $icons;

    }

}
