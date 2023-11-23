<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A simple module designed to contain custom logic for extending Craft.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\cchelpersmodule\models;

use modules\cchelpersmodule\CcHelpersModule;
use modules\cchelpersmodule\models\CustomConfig;

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
class ImageAttributes
{

    public function __construct($asset = false, $mobileAsset = false, $mq = false)
    {

      $this->mq = $mq;
      if ( empty($GLOBALS['_config:mq']) ) {
        $mediaJson = json_decode(file_get_contents(Craft::getAlias('@root') . '/mediaqueries.json'));
        $media = [];
        foreach ( $mediaJson as $key => $query ) {
          $media[$key] = $this->queryToString($query);
        }
        $this->media = $media;
        $GLOBALS['_config:mq'] = $media;
      } else {
        $this->media = $GLOBALS['_config:mq'];
      }
      if ( ! isset($GLOBALS['images::config']) ) {
          $GLOBALS['images::config'] = new CustomConfig('images');
      } 
      $this->config = $GLOBALS['images::config']->config;       
      $this->setAsset($asset, $mobileAsset);

    }

    public function setAsset($asset, $mobileAsset = false) {

      $this->asset = $asset;
      $this->mobileAsset = $mobileAsset;
      $this->url = $asset->getUrl();
      $this->id = $asset->id;

      if ( isset($this->asset->alt) ) {
        $this->alt = $this->asset->alt;
      }

    }

    /**
     * @var string
     *
     * @since 1.0.0
     * 
     * This variable is registered with the image config by the _construct() method.
     * Configuration includes the different formats and transforms.
     * 
     */
    public $config = false;


    /**
     * @var string
     *
     * @since 1.0.0
     * 
     * This variable is registered with the media queris object by the _construct() method.
     * The media queries are pulled from the mediaqueries.json file and are intended to 
     * mirror the same queries available to TailwindCSS and AlpineJs.
     * 
     */    
    public $media = false;

    public $mq = false;


    /**
     * @var string
     *
     * @since 1.0.0
     * 
     * This variable is registered with asset object by the _construct() method.
     * This allows our methods to process the data in conjuction with the configrations
     * that are registered to our object.
     */    
    public $asset = false;


    /**
     * @var string
     *
     * @since 1.0.0
     * 
     * This variable is registered with asset object by the _construct() method.
     * This allows our methods to process the data in conjuction with the configrations
     * that are registered to our object.
     */    
    public $mobileAsset = false;


    /**
     * @var string
     *
     * @since 1.0.0
     * 
     * This is the path that our custom getUrl() method will attempt to return;
     * It also substitutes for calls to the direct url property.
     */
    public $url = ''; 
    
    
    /**
     * @var string
     *
     * @since 1.0.0
     * 
     * This is the path that our custom getUrl() method will attempt to return;
     * It also substitutes for calls to the direct url property.
     */
    public $id = '';     


    /**
     * @var string
     *
     * @since 1.0.0
     * 
     * This is a simple placeholder for the altText field;
     */
    public $altText = '';


    /**
     * @method getUrl()
     * 
     * @since 1.0.0
     * 
     * This is a simple replacement for the getUrl() of the standard Element class. 
     * It basically allows us to return the value of $dummyPath, thus creating a simple
     * "faux" image that can be passed into test components, while still using the standard
     * method within components.
     */
    public function getUrl()
    {
      return $this->url;
    }
  
    public $srcSizes = ['1x', '1.5x'];


    /**
     * @method getSources()
     * 
     * @since 1.0.0
     * 
     * This function is used to get the source for a given image, based on the format given as the
     * $format variable. These sources can then be used within a Twig template to loop through the 
     * different sources and output them, ideally as part a <picture> element.
     * 
     * @param $format - this is the desired transform format, as defined in the config.
     * 
     * @return array - returns an array of the different sources.
     */    
    public function getSources($format)
    {

      // Define the sources array
      $sources = [];

      // If the requested format exists in our config...
      if ( $this->config['formats'][$format]) {

        if ( isset($this->config['formats'][$format]['sizes']) ) {
          $this->srcSizes = $this->config['formats'][$format]['sizes'];
        }

        // ... loop ove the sources in the desired format.
        foreach ( $this->config['formats'][$format]['sources'] as $key => $source ) {

          // If the media query exists OR the key is DEFAULT...
          if ( isset($this->media[$key]) || $key === 'DEFAULT') {

            // ... set the media query key
            $mq = isset($this->media[$key]) ? $this->media[$key] : false;

            if ( $source === 'raw' ) {
              $transform = $source;
            } else {
              // Set the source
              $transform = $this->config['transforms'][$source];

              // If webp is requested, we'll ensure we use that format.
              if ( $this->config['useWebP'] ) {
                $transform['format'] = 'webp';
              }
            }

            // If webp is requested, we'll ensure we use that format.
            if ( $this->config['useWebP'] ) {
              $transform['format'] = 'webp';
            }

            if ( getenv('WIREFRAME_MODE') === 'true' ) {
              array_push($sources, $this->setSourceWf($transform, $mq, $key));
            } else { 
              // Set the initial transform and push a new array of transformed attributes
              // to our sorces array.
              array_push($sources, $this->setSource($transform, $mq, $key));

              // If we're using fallbacks, we basically replicate the previous process, but 
              // reset the transform request. 
              if ( $this->config['useWebP'] && $this->config['useFallback'] && $source !== 'raw') {
                $transform = $this->config['transforms'][$source];
                array_push($sources, $this->setSource($transform, $mq, $key, true));
              }
            }
          }
        }
      }
      return $sources;
    }

    public function setSource($transform, $mq, $key, $fallback = false)
    {

      $asset = &$this->asset;
      if ( $this->checkMobile($key) && ! empty($this->mobileAsset) ) {
        $asset = &$this->mobileAsset;
      }

      if ( $this->isRaw($transform, $asset) ) {
        return array(
          'media' => $mq,
          'mediakey' => $key,
          'src' => $asset->url,
          'srcset' => false,
          'type' => $asset->getMimeType(),
          'width' => $asset->getWidth(),
          'height' => $asset->getHeight(),
          'fallback' => false,
        );
      }      

      $asset->setTransform($transform);
      $mime = (!$this->config['useWebP'] or $fallback) ? 'image/webp' : $asset->getMimeType();
      return array(
        'media' => $mq,
        'mediakey' => $key,
        'src' => $asset->url,
        'srcset' => $asset->getSrcset($this->srcSizes),
        'type' => $mime,
        'width' => $asset->getWidth(),
        'height' => $asset->getHeight(),
        'fallback' => $fallback,
      );

    }

    public function setSourceWf($transform, $mq, $key)
    {
            
      $width = isset($transform['width']) ? $transform['width'] : 400;
      $height = isset($transform['height']) ? $transform['height'] : 400;

        return array(
          'media' => $mq,
          'mediakey' => $key,
          'src' => '/helpers/wireframe-image/' . $width . '/' . $height,
          'srcset' => false,
          'type' => 'image/svg',
          'width' => $width,
          'height' => $height,
          'fallback' => false,
        );      
    }

    
    public function checkMobile($key)
    {
      if ( ! $this->mq || $key === 'DEFAULT' ) {
        return false;
      }
      return intval(substr($key,2)) < intval(substr($this->mq,2));
    }


    public function isRaw($transform, $asset)
    {
      if ( $this->config['useRawSvg'] ) {
        return ($transform === 'raw' || $asset->getMimeType() === 'image/svg+xml');
      }
      return ($transform === 'raw');
    }

    
    /**
     * @method queryToString()
     * 
     * @since 1.0.0
     * 
     * This method takes a query parameter as passed from the mediaqueries.json file and begins
     * translating the Tailwind CSS configuration into an actual media query that can be 
     * used when defining sources.
     * 
     * @param $query - this is the media query.
     * 
     * @return string - returns the formated media query string.
     */      
    public function queryToString($query) {
      $qstring = '';
      if ( is_string($query) ) {
        $qstring = '(min-width: ' . $query . ')';
      } else if ( is_array($query) ) {
        $inc = 0;
        foreach ( $query as $group) {
          if ( $inc > 0 ) {
            $qstring .= ', ';
          }
          $qstring .= $this->queryToString($group);
          $inc += 1;
        }
      } else {
        $inc = 0;
        foreach ( $query as $type => $rule ) {
          if ( $inc > 0 ) {
            $qstring .= ' and ';
          }
          $qstring .= $this->ruleToString($type, $rule);
          $inc += 1;
        }
      }
      return $qstring;
    }


    /**
     * @method ruleToString()
     * 
     * @since 1.0.0
     * 
     * This method takes a media type and rule and combines them into a proper
     * media query rule.
     * 
     * @param $type - the type of rule (eg min for min-width).
     * @param $rule - the rule to be applied to the type.
     * 
     * @return string - returns the string for the rule.
     */    
    public function ruleToString($type, $rule)
    {
      $ruleString = "(";
      switch ($type) {
        case 'min';
          $ruleString .= 'min-width: ' . $rule;
          break;
        case 'max';
          $ruleString .= 'max-width: ' . $rule;
          break;
        default:
          $ruleString .= $type . ': ' . $rule;        
      }
      $ruleString .= ")";
      return $ruleString;
    }

}