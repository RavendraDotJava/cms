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
use \cebe\markdown\Markdown;

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
class PageHeader extends Element
{

    public function __construct($entry)
    {

        $site = Craft::$app->getSites()->currentSite;
        if ( ! isset($GLOBALS['headers::config']) ) {
            $GLOBALS['headers::config'] = new CustomConfig('headers');
        }
        $config = $GLOBALS['headers::config']->config;

        // If the config file determines that the mode should be something other than
        // 'default' based on the section and entry type, set the value.
        if ( isset($config[$entry->section->handle]) ) {
            if ( isset($config[$entry->section->handle][$entry->type->handle]) ) {
                if ( ! empty($config[$entry->section->handle][$entry->type->handle]) ) {
                    $this->mode = $config[$entry->section->handle][$entry->type->handle];
                }
            }
        }

        // Begin construction by adding the entry to our model.
        $this->entry = $entry;

        // Define the page header.
        $this->heading = $entry->title;
        if ( isset($entry->heading) ) {
          if ( ! empty($entry->heading) ) {
            $this->heading = $entry->heading;
          }
        }

        // Define the page header.
        if ( isset($entry->introParagraph) ) {
          if ( ! empty($entry->introParagraph) ) {
            $this->intro = $this->renderMarkdown($entry->introParagraph);
          }
        }

        // Define the page header.
        if ( isset($entry->heroImage) ) {
          if ( ! empty($entry->heroImage) ) {
            if ( method_exists($entry->heroImage, 'one') ) {
                $this->heroImage = $entry->heroImage->one();
            } else {
                $this->heroImage = $entry->heroImage;
            }
          }
        }

        // Define the background media.
        if ( isset($entry->backgroundMedia) ) {
          if ( ! empty($entry->backgroundMedia) ) {
            if ( method_exists($entry->backgroundMedia, 'one') ) {
                $this->backgroundMedia = $entry->backgroundMedia->one();
            } else {
                $this->backgroundMedia = $entry->backgroundMedia;
            }
          }
        }

        if ( isset($entry->description) ) {
          if ( ! empty($entry->description) ) {
            if ( method_exists($entry->description, 'one') ) {
                $this->description = $entry->description->one();
            } else {
                $this->description = $entry->description;
            }
          }
        }

        // Define the page header.
        if ( isset($entry->buttons) ) {

          if ( ! empty($entry->buttons) ) {
            $this->buttons = $entry->buttons;
          }

          // if ( gettype($entry->buttons) === 'array' ) {
          //   if ( ! empty($entry->buttons) ) {
          //     $this->buttons = [];
          //     foreach ( $entry->buttons as $button ) {
          //       $button = (object)$button;
          //       array_push($this->buttons, $button);
          //     }
          //   }
          // } else if ( gettype($entry->buttons) === 'object' ) {
          //   foreach ( $entry->buttons->all() as $button ) {
          //     $this->buttons = [];
          //     foreach ( $entry->buttons->all() as $button ) {
          //       array_push($this->buttons, $button->button);
          //     }
          //   }
          // }

        }

      if ( isset($entry->verticalLine) ) {
        if ( ! empty($entry->verticalLine) ) {
          $this->verticalLine = $entry->verticalLine;
        }
      }


      if ( isset($entry->pageHeaderStyle) ) {
        if ( ! empty($entry->pageHeaderStyle) ) {
          $this->pageHeaderStyle = $entry->pageHeaderStyle;
        }
      }

      if ( isset($entry->pageHeaderPadding) ) {
        if ( ! empty($entry->pageHeaderPadding) ) {
          $this->pageHeaderPadding = $entry->pageHeaderPadding;
        }
      }

      if ( isset($entry->radiantCircles) ) {
        if ( ! empty($entry->radiantCircles) ) {
          $this->radiantCircles = $entry->radiantCircles;
        }
      }

      if ( isset($entry->postOverview) ) {
        if ( ! empty($entry->postOverview) ) {
          $this->postOverview = $entry->postOverview;
        }
      }

      if ( isset($entry->categories) ) {
        if ( ! empty($entry->categories) ) {
          $this->categories = $entry->categories;
        }
      }

      if ( isset($entry->headerTextColor) ) {
        if ( ! empty($entry->headerTextColor) ) {
          $this->headerTextColor = $entry->headerTextColor;
        }
      }

      if ( isset($entry->postAuthor) ) {
        if ( ! empty($entry->postAuthor) ) {
          $this->postAuthor = $entry->postAuthor;
        }
      }

    }


    /**
     * @var string
     *
     * @since 1.0.0
     *
     * This is the heading of the page header
     */
    public $heading = '';


    /**
     * @var string
     *
     * @since 1.0.0
     *
     * This is simply the id of the asset, included mostly for reference;
     */
    public $intro = '';


    /**
     * @var string
     *
     * @since 1.0.0
     *
     * This is simply the default URL of the original, raw asset;
     */
    public $buttons = false;


    /**
     * @var string
     *
     * @since 1.0.0
     *
     * This is the alt text of the image asset;
     */
    public $image = false;


    /**
     * @var string
     *
     * @since 1.0.0
     *
     * This is the alt text of the image asset;
     */
    public $imageMobile = false;


    /**
     * @var string
     *
     * @since 1.0.0
     *
     * This is the alt text of the image asset;
     */
    public $mode = 'default';


   /**
     * @var string
     *
     * @since 1.0.0
     *
     * This is the heading of the page header
     */
    public $entry = false;


   /**
     * @var string
     *
     * @since 1.0.0
     *
     * This is the heading of the page header
     */
    public $bg = '';


    public static function renderMarkdown($content)
    {
        $parser = new Markdown();
        return $parser->parse($content);
    }

}
