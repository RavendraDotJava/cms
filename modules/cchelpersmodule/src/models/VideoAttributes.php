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
class VideoAttributes extends ImageAttributes
{   

    public function __construct($config = [])
    {

        parent::__construct($config);
        $this->videoType = $this->asset->videoType;
        $this->videoId = $this->asset->videoId;
        $this->videoTranscript = $this->asset->videoTranscript;

    }    

   public $id = 0;
   public $videoType = '';
   public $videoId = '';
   public $videoTranscript = '';

}
