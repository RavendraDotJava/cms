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

use Craft;
use craft\base\Element;
use craft\helpers\Json;

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
class ModuleBlock
{

    public function __construct($block, $config, $dataOnly = true)
    {

        $modules = $config['modules'];
        $moduleType = $block->type->handle;
        $this->handle = $moduleType;
        if ( ! isset($modules[$block->type->handle]) && isset($modules['DEFAULT']) ) {
          foreach ( $modules['DEFAULT'] as $key => $value ) {
            if ( isset($this->$key) ) {
              $this->$key = $value;
            }
          }
        }

        if ( isset($block->module) ) {
          if ( is_string($block->module) ) {
            $settings = Json::decode($block->module);
          } else {
            $settings = $block->module;
          }
          $background = isset($settings['backgrounds']) ? $settings['backgrounds'] : 'white';
          $bgCompress = false;

          // if ( ! empty($GLOBALS['_modules:previous']) ) {
          //   if ( $GLOBALS['_modules:previous']->background === $background ) {
          //     $bgCompress = true;
          //   }
          // }

          if ( isset($settings['padding']) ) {
            if ( isset($settings['paddingBottom']) ) {
              if ( $bgCompress && getenv('WIREFRAME_MODE') !== 'true' ) {
                $this->paddingClass = $this->getPaddingClass($config['values']['padding']['none'], 'top');
              } else {
                $this->paddingClass = $this->getPaddingClass($config['values']['padding'][$settings['padding']], 'top');
              }
              $this->paddingClass .= ' ' . $this->getPaddingClass($config['values']['padding'][$settings['paddingBottom']], 'bottom');

            } else {
              if ( $bgCompress && getenv('WIREFRAME_MODE') !== 'true' ) {
                $this->paddingClass = $this->getPaddingClass($config['values']['padding']['none'], 'top');
                $this->paddingClass .= ' ' . $this->getPaddingClass($config['values']['padding'][$this->getPaddingKey($settings['padding'])], 'bottom');
              } else {
                $this->paddingClass = $this->getPaddingClass($config['values']['padding'][$this->getPaddingKey($settings['padding'])], 'even');
              }
            }
          }

          if ( isset($background) ) {
            $this->backgroundClass = $config['values']['backgrounds'][$background];
            $this->background = $background;

            // Custom settings per background.
            // This can allow us to control certain colours based on the background choice.
            if ( isset($config['values']['custom']['button'][$background]) ) {
              $this->btnType = $config['values']['custom']['button'][$background];
            }
          }

          if ( isset($settings['decorations']) ) {
            if ( isset($config['options']) ) {
              if ( isset($config['options']['decorations']) ) {
                  if ( isset($config['options']['decorations'][$settings['decorations']]) ) {
                    $this->decorations = $settings['decorations'];
                  }
              }
            }

          }

          if ( isset($settings['overflow']) ) {
            if ( isset($config['options']) ) {
              if ( isset($config['options']['overflow']) ) {
                  if ( isset($config['options']['overflow'][$settings['overflow']]) ) {
                    $this->overflow = $settings['overflow'];
                  }
              }
            }
          }


        }

        if ( ! empty($settings['moduleId']) ) {
          $this->id = $settings['moduleId'];
        } else {
          $this->id = $block->type->handle . '-' . $this->moduleCount;
        }

        $this->classes = trim(implode(' ', [
          $this->backgroundClass,
          $this->paddingClass,
        ]));

        if ( ! $dataOnly ) {

          $GLOBALS['_modules:count'] += 1;
          $this->moduleCount = $GLOBALS['_modules:count'];
          $this->totalModules = $GLOBALS['_modules:total'];
          $this->zIndex = $this->moduleCount;

          $GLOBALS['_modules:previous'] = $this;

        }

    }

    public function getPaddingKey($key)
    {
      if ( empty($key) ) {
        return "none";
      }
      return $key;
    }

    public function getPaddingClass($config, $key)
    {

      if (is_string($config)) {
        return $config;
      } else if (is_array($config) ) {
        if ( isset($config[$key]) ) {
          return $config[$key];
        }
      }
      return '';

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
    public $handle = 'module';
    public $id = false;
    public $moduleCount = 0;
    public $paddingClass = '';
    public $backgroundClass = '';
    public $decorations = '';
    public $overflow = '';
    public $classes = '';

    /**
     * Custom properties for customization.
     */
    public $btnType = '';

}
