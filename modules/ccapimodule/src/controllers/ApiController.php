<?php

/**
 * ccapi module for Craft CMS 3.x
 *
 * A separate model for creating API abstractions in Craft. Useful for various PHP reverse proxies.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2021 Craft&Crew
 */

namespace modules\ccapimodule\controllers;

use modules\ccapimodule\CcapiModule;

use Craft;
use craft\web\Controller;

/**
 * Sample Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your module’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Craft&Crew
 * @package   CcapiModule
 * @since     1.0.0
 */
class ApiController extends Controller
{
  public $enableCsrfValidation = false;



    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected array|bool|int $allowAnonymous = [
        'index',
        'get-sample',
        'get-sample-todos',
        'listen-shipbob-order-status'
    ];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our module's index action URL,
     * e.g.: actions/ccapi-module/sample
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Default Controller';

        echo $result;
        die();
    }

    /**
     * Handle a request going to our module's actionDoSomething URL,
     * e.g.: actions/ccapi-module/sample/do-something
     *
     * @return mixed
     */
    public function actionGetSample()
    {
        $response = CcapiModule::$instance->sample->getSampleData(1);
        return $this->asJson($response);
    }

    /**
     * Handle a request going to our module's actionDoSomething URL,
     * e.g.: actions/ccapi-module/sample/do-something
     *
     * @return mixed
     */
    public function actionGetSampleTodos()
    {
        $response = CcapiModule::$instance->sample->getSampleData(2);
        return $this->asJson($response);
    }

    /**
     * Handle a request going to our module's actionDoSomething URL,
     * e.g.: actions/ccapi-module/sample/do-something
     *
     * @return mixed
     */
    public function actionListenShipbobOrderStatus()
    {

      $response = CcapiModule::$instance->shipbob->getOrderStatus();
      return $this->asJson($response);
    }
}
