<?php
/**
 * ccapi module for Craft CMS 3.x
 *
 * A separate model for creating API abstractions in Craft. Useful for various PHP reverse proxies.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2021 Craft&Crew
 */

namespace modules\ccapimodule\services;

use modules\ccapimodule\services\Base as BaseService;

use Craft;
use craft\base\Component;

/**
 * Base Service
 *
 * All of your module’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other modules can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Craft&Crew
 * @package   CcapiModule
 * @since     1.0.0
 */
class Sample extends BaseService
{

    // Public Properties
    // =========================================================================

    // Set this service to communicate with gorest.co.in
    public $service = 'https://gorest.co.in/';

    // Set our method to GET
    public $method = 'GET';

    // Public Methods
    // =========================================================================

    /**
     * This function requests a series of posts from the gorest placeholder API.
     * The purposes of this function are primarily for demonstration of how 
     * the API module can be used to handle reverse-proxy API calls.
     *
     * From any other plugin/module file, call it like this:
     *
     *     CcapiModule::$instance->sample->getSampleData()
     *
     * @return mixed
     */
    public function getSampleData($page = 1)
    {

        $path = $this->paginateRequest('/public/v1/posts', $page);
        return $this->getResource($path);

    } 
    
    /**
     * This function requests a series of posts from the gorest placeholder API.
     * The purposes of this function are primarily for demonstration of how 
     * the API module can be used to handle reverse-proxy API calls.
     *
     * From any other plugin/module file, call it like this:
     *
     *     CcapiModule::$instance->sample->getSampleData()
     *
     * @return mixed
     */
    public function getSampleToDos($page = 1)
    {

        $path = $this->paginateRequest('/public/v1/todos', $page);
        return $this->getResource($path);

    }     
}
