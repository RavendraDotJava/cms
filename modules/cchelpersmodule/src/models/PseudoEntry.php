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
class PseudoEntry extends Element
{

    public function __construct()
    {
      $path = Craft::$app->request->fullPath;
      $segments = explode('/page/', $path);
      $this->path = $segments[0];

      $key = ($this->path === '' ) ? $key = 'default' : $this->path;

      $config = Craft::$app->getConfig()->getConfigFromFile('pseudoEntry');

      if ( isset($config[$key]) ) {
          $this->title = $config[$key]['title'];
          $this->introParagraph = $config[$key]['content'];
          $this->section = (object)array(
              'handle' => $config[$key]['handle'],
              'name' => $config[$key]['title'],
          );
          $this->type = (object)array(
              'handle' => $config[$key]['handle'],
              'name' => $config[$key]['title'],
          );
          
          if ( isset($config[$key]['image']) ) {
            $this->heroImage = $config[$key]['image'];
          }
          if ( isset($config[$key]['buttons']) ) {
            $this->buttons = $config[$key]['buttons'];
          }          
      } else {

        $notFound = Craft::$app->getGlobals()->getSetByHandle('notFound');
        $this->section = (object)array(
            'handle' => 'notFound',
            'name' => '404 Page',
        );
        $this->type = (object)array(
            'handle' => 'notFound',
            'name' => '404 Page',
        );          
        $this->title = ( ! empty($notFound->heading) ) ? $notFound->heading : '404';
        $this->heading = ( ! empty($notFound->heading) ) ? $notFound->heading : '404';
        $this->introParagraph = ( ! empty($notFound->introParagraph) ) ? $notFound->introParagraph : '<p>Page not Found</p>';
        $this->heroImage = ( ! empty($notFound->heroImage) ) ? $notFound->heroImage : false;
        $this->buttons = ( ! empty($notFound->buttons) ) ? $notFound->buttons : false;
        
      }

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
    public $path = false;
    public $section = false;
    public $introParagraph = false;
    public $type = '';
    public $heroImage = false;
    public $buttons = false;

}
