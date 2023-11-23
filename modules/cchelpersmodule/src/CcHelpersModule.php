<?php
/**
 * CC Helpers module for Craft CMS 3.x
 *
 * A simple module designed to contain custom logic for extending Craft.
 * This is an excellent place for adding simple, funcitional helpers for use
 * when building out a site.
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2020 Craft&Crew
 */

namespace modules\cchelpersmodule;

use modules\cchelpersmodule\assetbundles\cchelpersmodule\CcHelpersModuleAsset;
use modules\cchelpersmodule\services\Helpers as HelpersService;
use modules\cchelpersmodule\variables\CcHelpersModuleVariable;
use modules\cchelpersmodule\twigextensions\CcHelpersModuleTwigExtension;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\TemplateEvent;
use craft\i18n\PhpMessageSource;
use craft\web\View;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;
use craft\web\twig\variables\CraftVariable;

use craft\elements\Entry;
use craft\events\ModelEvent;

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
 * @package   CcHelpersModule
 * @since     1.0.0
 *
 * @property  HelpersService $helpers
 */
class CcHelpersModule extends Module
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this module class so that it can be accessed via
     * CcHelpersModule::$instance
     *
     * @var CcHelpersModule
     */
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/cchelpersmodule', $this->getBasePath());
        $this->controllerNamespace = 'modules\cchelpersmodule\controllers';

        // Translation category
        $i18n = Craft::$app->getI18n();
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($i18n->translations[$id]) && !isset($i18n->translations[$id.'*'])) {
            $i18n->translations[$id] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@modules/cchelpersmodule/translations',
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

        // Set helper globals
        $GLOBALS['_config:mq'] = [];
        $GLOBALS['_modules:count'] = 0;
        $GLOBALS['_modules:total'] = 0;
        $GLOBALS['_modules:previous'] = false;
        $GLOBALS['_landingpage'] = false;

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * Set our $instance static property to this class so that it can be accessed via
     * CcHelpersModule::$instance
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
                      Craft::$app->getView()->registerAssetBundle(CcHelpersModuleAsset::class);
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
        Craft::$app->view->registerTwigExtension(new CcHelpersModuleTwigExtension());

        // Register our variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('ccHelpersModule', CcHelpersModuleVariable::class);
            }
        );

        // Register our site routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['helpers/wireframe-image/<width:\d+>/<height:\d+>'] = 'cc-helpers-module/image/get-wireframe-image';
                // echo '<pre>';
                // print_r($event);
                // echo '</pre>';
                // exit;
            }
        );


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
                'cc-helpers-module',
                '{name} module loaded',
                ['name' => 'CC Helpers']
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
}
