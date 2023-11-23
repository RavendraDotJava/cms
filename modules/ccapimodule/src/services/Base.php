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

use modules\ccapimodule\CcapiModule;

use Craft;
use craft\base\Component;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

/**
 * Base Service
 *
 * The Base service class is intended as a common starting point for API abstractions used
 * in this module. It provides a basic structure that is meant to be extended by a unique service
 * for each separate API service that we want to reverse-proxy against.
 *
 * This includes some common configuration variables, along with core methods for requesting
 * and handling API requests.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Craft&Crew
 * @package   CcapiModule
 * @since     1.0.0
 */
class Base extends Component
{
    // Public Properties
    // =========================================================================

    // Defines the base timeout
    public $timeout = 30.0;

    // Defines a placeholder for the service of a given service.
    // This is equivilent to the base_uri data used by Guzzle
    public $service = false;

    // Defines the method that will be used within the Guzzle-based requests.
    public $method = 'POST';

    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin/module file, call it like this:
     *
     *     CcapiModule::$instance->base->exampleService()
     *
     * @return mixed
     */
    public function getResource($path, $data = array(), $headers = array())
    {

        if ( empty($this->service) ) { return false; }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->service,
            // You can set any number of default request options.
            'timeout'  => $this->timeout,
        ]);

        try {
            $request = $client->request($this->method, $path);
            $response = json_decode((string) $request->getBody());
        } catch (ClientException $e) {
            $response = array(
                'error' => true,
                'details' => $e->getMessage(),
                'fullMessage' => Psr7\Message::toString($e->getResponse()),
                'request' => Psr7\Message::toString($e->getRequest())
            );
            $response = json_encode($response);
        }

        return $response;

    }

    public function paginateRequest($path, $page)
    {

        if ( $page > 1 ) {
            $path .= '?page=' . $page;
        }
        return $path;

    }

}
