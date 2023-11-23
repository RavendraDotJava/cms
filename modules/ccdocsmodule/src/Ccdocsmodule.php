<?php
/**
 * ccdocsmodule module for Craft CMS 3.x
 *
 * A module for adding custom documentation to CraftCMS to improve the author experience
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2022 Craft&Crew
 */

namespace modules\ccdocsmodule;

use modules\ccdocsmodule\assetbundles\ccdocsmodule\CcdocsmoduleAsset;
use modules\ccdocsmodule\services\CcdocsmoduleService as CcdocsmoduleServiceService;
use modules\ccdocsmodule\widgets\CcdocsmoduleWidget as CcdocsmoduleWidgetWidget;
use modules\ccdocsmodule\twigextensions\CcdocsmoduleTwigExtension;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\events\TemplateEvent;
use craft\i18n\PhpMessageSource;
use craft\web\View;
use craft\web\UrlManager;
use craft\web\twig\variables\Cp;
use craft\services\Dashboard;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;

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
 * @package   Ccdocsmodule
 * @since     1.0,0
 *
 * @property  CcdocsmoduleServiceService $ccdocsmoduleService
 */
class Ccdocsmodule extends Module
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this module class so that it can be accessed via
     * Ccdocsmodule::$instance
     *
     * @var Ccdocsmodule
     */
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {

        // Check to see if we are actually supposed to do the documentation.
        $doDocumentation = false;
        $path = 'custom/documentation';
        $docConfig = Craft::$app->getConfig()->getConfigFromFile($path);

        if ( ! empty($docConfig) ) {

            // Typecast as object
            $docConfig = (object)$docConfig;

            // Set devMode
            $user = Craft::$app->getUser()->getIdentity();
            if ( ! empty($user) ) {
                $user = $user->username;
            }
            $docConfig->devMode = false;
            if ( isset($docConfig->devUser) ) {
                $docConfig->devMode = ($docConfig->devUser === $user) ? true : false;
            }          

            $docConfig->seoFieldObject = false; 
            if ( isset($docConfig->seoField) ) {
                $seoField = Craft::$app->fields->getFieldByHandle($docConfig->seoField);
                if ( ! empty($seoField) ) {
                    $docConfig->seoFieldObject = $seoField;
                }
            }

            // Pull in documentation descriptions
            $descriptionsPath = rtrim(self::getBasePath(),'/') . '/descriptions/strings.php';
            if ( file_exists($descriptionsPath) ) {
                $docConfig->descriptions = require $descriptionsPath;
            }

            $GLOBALS['documentation::config'] = $docConfig;
            if ( ! empty($docConfig) ) {
                if ( isset($docConfig->useDocumentation) ) {
                $doDocumentation = $docConfig->useDocumentation; 
                }
            }

        }

        // echo '<pre>';
        // print_r($docConfig);
        // echo '</pre>';

        if ( $doDocumentation ) {
            $GLOBALS['documentation::sections'] = [];
            Craft::setAlias('@modules/ccdocsmodule', $this->getBasePath());
            $this->controllerNamespace = 'modules\ccdocsmodule\controllers';

            // Translation category
            $i18n = Craft::$app->getI18n();
            /** @noinspection UnSafeIsSetOverArrayInspection */
            if (!isset($i18n->translations[$id]) && !isset($i18n->translations[$id.'*'])) {
                $i18n->translations[$id] = [
                    'class' => PhpMessageSource::class,
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@modules/ccdocsmodule/translations',
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
    }

    /**
     * Set our $instance static property to this class so that it can be accessed via
     * Ccdocsmodule::$instance
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
                        Craft::$app->getView()->registerAssetBundle(CcdocsmoduleAsset::class);
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
        Craft::$app->view->registerTwigExtension(new CcdocsmoduleTwigExtension());        

        // Register our CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['documentation'] = 'ccdocsmodule/default';
                $event->rules['documentation/sections/<groupHandle:{slug}>'] = 'ccdocsmodule/default/docs-section';
                $event->rules['documentation/sections/<groupHandle:{slug}>/<typeHandle:{slug}>'] = 'ccdocsmodule/default/docs-entry-type';
                $event->rules['documentation/<groupHandle:{slug}>'] = 'ccdocsmodule/default/docs-article';
                $event->rules['documentation/fields/<fieldHandle:{slug}>'] = 'ccdocsmodule/default/docs-field';
            }
        );

        // Register Documentation Templates
        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['_docs'] = __DIR__ . '/docs';
            }
        );        

        // Register Documentation Option
        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) {
                $event->navItems[] = [
                    'url' => 'documentation',
                    'label' => 'Documentation',
                    'icon' => '@webroot/ui/cp/admin-icons/documentation.svg',
                ];
            }
        );        

        // Register our widgets
        Event::on(
            Dashboard::class,
            Dashboard::EVENT_REGISTER_WIDGET_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = CcdocsmoduleWidgetWidget::class;
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
                'ccdocsmodule',
                '{name} module loaded',
                ['name' => 'ccdocsmodule']
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
}
