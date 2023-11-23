<?php
/**
 * CCFields module for Craft CMS 3.x
 *
 * A custom module that contains
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2021 Craft&Crew
 */

namespace modules\ccfieldsmodule;

use modules\ccfieldsmodule\assetbundles\ccfieldsmodule\CCFieldsModuleAsset;
use modules\ccfieldsmodule\fields\Instructions as InstructionsField;
use modules\ccfieldsmodule\fields\Icon as IconField;
use modules\ccfieldsmodule\fields\Module as ModuleField;
use modules\ccfieldsmodule\fields\Heading as HeadingField;
use modules\ccfieldsmodule\fields\PresetDropdown as PresetDropdownField;
use modules\ccfieldsmodule\twigextensions\CCFieldsModuleTwigExtension;
use modules\ccfieldsmodule\services\IconService as IconService;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\TemplateEvent;
use craft\i18n\PhpMessageSource;
use craft\web\View;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use craft\commerce\elements\Order;
use craft\commerce\elements\Order\saveAddress;


use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\Module;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Craft&Crew
 * @package   CCFieldsModule
 * @since     1.0.0
 *
 */
class CCFieldsModule extends Module
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this module class so that it can be accessed via
     * CCFieldsModule::$instance
     *
     * @var CCFieldsModule
     */
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/ccfieldsmodule', $this->getBasePath());
        $this->controllerNamespace = 'modules\ccfieldsmodule\controllers';

        // Translation category
        $i18n = Craft::$app->getI18n();
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($i18n->translations[$id]) && !isset($i18n->translations[$id.'*'])) {
            $i18n->translations[$id] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@modules/ccfieldsmodule/translations',
                'forceTranslation' => true,
                'allowOverrides' => true,
            ];
        }

        // Base template directory
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) {
            if (is_dir($baseDir = $this->getBasePath().DIRECTORY_SEPARATOR.'templates')) {
                $e->roots[$this->id] = $baseDir;
            }
        });

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * Set our $instance static property to this class so that it can be accessed via
     * CCFieldsModule::$instance
     *
     * Called after the module class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$instance = $this;

        // Load our AssetBundle
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function (TemplateEvent $event) {
                    try {
                        Craft::$app->getView()->registerAssetBundle(CCFieldsModuleAsset::class);
                    } catch (InvalidConfigException $e) {
                        Craft::error(
                            'Error registering AssetBundle - '.$e->getMessage(),
                            __METHOD__
                        );
                    }
                }
            );
        }

        // Add in our Twig extensions
        Craft::$app->view->registerTwigExtension(new CCFieldsModuleTwigExtension());

        $GLOBALS['icons'] = IconService::getIconFileValidation();
        $GLOBALS['currentHeading'] = 'h2';

        // Register our fields
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = ModuleField::class;
                $event->types[] = HeadingField::class;
                if ( self::isFieldConfigured('ccFieldsInstructions') ) {
                    $event->types[] = InstructionsField::class;
                }
                if ( self::isFieldConfigured('ccFieldsIcon') ) {
                    if ( $GLOBALS['icons'] ) {
                        $event->types[] = IconField::class;
                    }
                }
                if ( self::isFieldConfigured('ccPresetDropdowns') ) {
                    $event->types[] = PresetDropdownField::class;
                }

            }
        );

        // Event::on(Order::class, Order::EVENT_AFTER_COMPLETE_ORDER, static function(Event $event) {
        //   $order = $event->sender;


        // });

        Event::on(Order::class, Order::EVENT_AFTER_COMPLETE_ORDER, static function(Event $event) {
          /** @var Order $order */
          $order = $event->sender;

          // Custom logic here to determine if to save the addresses or not
          if ($order->saveOrderAddress) {
              if ($billingAddress = $order->getBillingAddress()) {
                  Craft::$app->getElements()->duplicateElement($billingAddress, ['ownerId' => $order->getCustomerId()]);
              }

              if ($shippingAddress = $order->getShippingAddress()) {
                  Craft::$app->getElements()->duplicateElement($shippingAddress, ['ownerId' => $order->getCustomerId()]);
              }
          }
      });
/**
 * Logging in Craft involves using one of the following methods:
 *
 * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
 * Craft::info(): record a message that conveys some useful information.
 * Craft::warning(): record a warning message that indicates something unexpected has happened.
 * Craft::error(): record a fatal error that should be investigated as soon as possible.
 *
 * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
 *
 * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
 * the category to the method (prefixed with the fully qualified class name) where the constant appears.
 *
 * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
 * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
        Craft::info(
            Craft::t(
                'ccfields-module',
                '{name} module loaded',
                ['name' => 'CCFields']
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    public static function isFieldConfigured($field)
    {

        $config = Craft::$app->getConfig()->getConfigFromFile('custom');
        if (isset($config[$field]) ) {
            if ( $config[$field] ) {
                return true;
            }
        }
        return false;

    }

}
