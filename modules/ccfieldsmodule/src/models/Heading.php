<?php
/**
 * CCFields module for Craft CMS 3.x
 *
 * A custom module that contains
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2021 Craft&Crew
 */

namespace modules\ccfieldsmodule\models;

use modules\ccfieldsmodule\CCFieldsModule;

use Craft;
use craft\base\Model;
use craft\helpers\Html;
use craft\helpers\Template;

/**
 * Instructions Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Craft&Crew
 * @package   CCFieldsModule
 * @since     1.0.0
 */
class Heading extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $heading = '';
    public $level = 'h2';
    public $default = 'h2';
    public $sizing = '';
    public $attributes = [];
    public $emphasis = 'font-display text-display';

    public $tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

    public function __construct($heading)
    {

      $this->level = $GLOBALS['currentHeading'];

      if ( isset($heading['heading']) ) {
        $this->heading = $heading['heading'];
      }
      if ( isset($heading['levels']) ) {
        $this->level = $heading['levels'];
      }
      if ( isset($heading['sizing']) ) {
        $this->sizing = $heading['sizing'];
      }
      if ( isset($heading['attributes']) ) {
        $this->attributes = $heading['attributes'];
      }

    }

    public function get($attributes = [], $size = false)
    {

      if ( empty($this->heading) ) {
        return '';
      }

      if ( ! $size ) {
        if ( ! empty($this->level) ) {
          $size = $this->level;
        } else {
          $size = $this->default;
        }
      }

      if ( isset($attributes['emphasis']) ) {
        $this->emphasis = $attributes['emphasis'];
        unset($attributes['emphasis']);
      }

      if ( isset($attributes['class']) ) {
        if ( isset($this->sizing) ) {
          $attributes['class'] = $this->sizing . ' ' . $attributes['class'];
        }
      } else if ( isset($this->sizing) ) {
        $attributes['class'] = $this->sizing;
      }

      return Template::raw(Html::tag($size, $this->widont($this->heading), $attributes));

    }

    public function set($attributes = [])
    {

      $get = $this->get($attributes);
      $this->advance();
      return $get;

    }

    public function advance()
    {

      $index = 0;
      foreach ( $this->tags as $i => $tag ) {
        if ( $tag === $this->level ) {
          $index = $i;
        }
      }

      $GLOBALS['currentHeading'] = $this->tags[$index + 1];

    }

    public function widont($str = '')
    {

        $str = rtrim($str);
        $maxLen = 6;
        $space = strrpos($str, ' ');
        $len = strlen(substr($str, $space + 1));
        if ($space !== false && $len <= $maxLen)
        {
            $str = substr($str, 0, $space).'&nbsp;'.substr($str, $space + 1);
        }
        $str = preg_replace('/\*([^\*]+)\*/', '<span class="' . $this->emphasis . '">$1</span>', $str);
        return $str;
    }

    public function __toString()
    {
      return $this->get($this->attributes, $this->level);
    }

}
