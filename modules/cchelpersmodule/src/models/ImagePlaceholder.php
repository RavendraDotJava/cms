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
use modules\cchelpersmodule\models\ImageAttributes;

use Craft;

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
class ImagePlaceholder extends ImageAttributes
{

    public function setAsset($asset, $mobileAsset = false) {
      
      $assetParams = explode(':', $asset);
      $this->origin = $assetParams[0];
      $this->assetId = $assetParams[1];

    }

    /**
     * @var string
     *
     * @since 1.0.0
     * 
     * This is a simple placeholder for the altText field;
     */
    public $origin = '';
    public $assetId = '';


    public function setSource($transform, $mq, $key, $fallback = false)
    {

      $sources = [];
      $srcset = '';

      foreach ( $this->srcSizes as $size ) {

        $numsize = rtrim($size, 'x');
        $numsize = floatval($size);

        if ( $this->origin = '@picsum' ) {
          $src = 'https://picsum.photos/id/' . $this->assetId . '/' . ($transform['width']*$numsize) . '/' . ($transform['height']*$numsize);
          if ($this->config['useWebP'] && ! $fallback) {
            $src .= '.webp';
          }
        }

        array_push($sources, $src);
        $srcset .= $src . ' ' . $size . ',';

      }

      $mime = (!$this->config['useWebP'] || $fallback) ? 'image/jpeg' : 'image/webp';
      return array(
        'media' => $mq,
        'mediakey' => $key,
        'src' => $sources[0],
        'srcset' => rtrim($srcset, ','),
        'type' => $mime,
        'width' => $transform['width'],
        'height' => $transform['height'],
        'fallback' => $fallback,
      );

    }

}
