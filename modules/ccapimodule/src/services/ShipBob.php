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
class ShipBob extends BaseService
{

    // Public Properties
    // =========================================================================

    // Set this service to communicate with gorest.co.in
    // public $service = 'https://gorest.co.in/';

    // Set our method to POST
    public $method = 'POST';

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

    public function getOrderStatus()
    {

      // Get the request
      $request = Craft::$app->getRequest();

      // Get the body params based on name
      $orderId         = $request->getBodyParam('orderId');
      $trackingNum     = $request->getBodyParam('orderTrackingNumber');
      $trackingUrl     = $request->getBodyParam('orderTrackingUrl');
      $trackingCarrier = $request->getBodyParam('orderTrackingCarrier');
      $statusDetails   = $request->getBodyParam('orderStatusDetails');

      $headers = $request->getHeaders(); // Get the request headers

      // Get the order based on the orderId param
      $order = \craft\commerce\Plugin::getInstance()
          ->getOrders()
          ->getOrderById($orderId);

      if ($order == null)
        return ['result' => 'Order ID: ' . $orderId  . ' was not found'];

      // Check the header for Shipbob topic
      if($headers->has('shipbob-topic')){
        $topic = $headers->get('shipbob-topic');

        // Set $id to the appropriate order status ID from Craft based on header topic
        // Header topics: https://developer.shipbob.com/webhooks
        if ($topic == 'shipment_exception' || $topic == 'shipment_onhold') {
          $id = 2; // On Hold
        } else if($topic == 'order_shipped') {
          $id = 3; // Shipping
        } else if($topic == 'shipment_delivered') {
          $id = 4; // Delivered
        } else if ($topic == 'shipment_cancelled') {
          $id = 5; // Cancelled
        }

        // Set the order status
        $order->orderStatusId = $id;
        // return $topic;
      } else {
        return ['result' => 'Order status not changed: shipbob-topic not found'];
      }

      // Set the order tracking fields
      $order->orderTrackingNumber  = $trackingNum;
      $order->orderTrackingUrl     = $trackingUrl;
      $order->orderTrackingCarrier = $trackingCarrier;

      // Set status detials (exception and on hold orders have this)
      $order->orderStatusDetails = $statusDetails;

      // Save the order
      $result = Craft::$app->getElements()->saveElement($order);

      return $order;
    }
}
