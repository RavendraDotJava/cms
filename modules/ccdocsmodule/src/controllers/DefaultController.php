<?php
/**
 * ccdocsmodule module for Craft CMS 3.x
 *
 * A module for adding custom documentation to CraftCMS to improve the author experience
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2022 Craft&Crew
 */

namespace modules\ccdocsmodule\controllers;

use modules\ccdocsmodule\Ccdocsmodule;

use yii\web\Response;

use Craft;
use craft\web\Controller;
use craft\web\View;

/**
 * Default Controller
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
 * @package   Ccdocsmodule
 * @since     1.0,0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected array|bool|int $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our module's index action URL,
     * e.g.: actions/ccdocsmodule/default
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $variables = [];
        return $this->renderTemplate(
            '_docs/index.twig',
            $variables,
            View::TEMPLATE_MODE_CP
        );
    }

    /**
     * Handle a request going to our module's actionDoSomething URL,
     * e.g.: actions/ccdocsmodule/default/do-something
     *
     * @return mixed
     */
    public function actionDocsIndex(): Response
    {
        $variables = [];
        return $this->renderTemplate(
            '_docs/index.twig',
            [],
            View::TEMPLATE_MODE_CP
        );
    }

    /**
     * Handle a request going to our module's actionDoSomething URL,
     * e.g.: actions/ccdocsmodule/default/do-something
     *
     * @return mixed
     */
    public function actionDocsArticle(): Response
    {
        $section = Craft::$app->request->getSegment(2);
        $templatePath = Craft::getAlias('@modules/ccdocsmodule') . '/docs/pages/' . $section . '.twig';
        if ( file_exists($templatePath) ) {
            $template = '_docs/pages/' . $section . '.twig';
            return $this->renderTemplate(
                $template,
                [],
                View::TEMPLATE_MODE_CP
            );
        } else {
          return $this->renderTemplate(
                '_docs/404.twig',
                [],
                View::TEMPLATE_MODE_CP
            );  
        }
    } 
    
    public function actionDocsSection(): Response
    {
        $template = '_docs/section.twig';

        $handle = Craft::$app->request->getSegment(3);
        $section = Craft::$app->sections->getSectionByHandle($handle);
        $types = $section->entryTypes;

        return $this->renderTemplate(
            $template,
            [
                'handle'  => $handle,
                'section' => $section,
                'title' => $section->name,
                'types' => $types,
            ],
            View::TEMPLATE_MODE_CP
        );        
    }

    public function actionDocsEntryType(): Response
    {
        $template = '_docs/entry-type.twig';

        $sectionhandle = Craft::$app->request->getSegment(3);
        $handle = Craft::$app->request->getSegment(4);
        $section = Craft::$app->sections->getSectionByHandle($sectionhandle);
        $type = false;

        foreach ( $section->entryTypes as $entryType ) {
            if ( $entryType->handle === $handle ) {
                $type = $entryType;
            }
        }

        if ( ! empty($type) ) {
            return $this->renderTemplate(
                $template,
                [
                    'handle'  => $handle,
                    'section' => $section,
                    'type'    => $type,
                    'title' => $section->name . ' - ' . $entryType->name,
                    'parentTitle' => $section->name,
                    'parentPath' => dirname(Craft::$app->request->getPathInfo()),
                ],
                View::TEMPLATE_MODE_CP
            );
        } else {
          return $this->renderTemplate(
                '_docs/404.twig',
                [],
                View::TEMPLATE_MODE_CP
            );  
        }      
    }

    public function actionDocsField(): Response
    {
        $fieldHandle = Craft::$app->request->getSegment(3);
        $fieldTemplate = 'fields/' . $fieldHandle . '.twig';
        $templatePath = Craft::getAlias('@modules/ccdocsmodule') . '/docs/' . $fieldTemplate;
        $template = '_docs/' . $fieldTemplate;
        $config = $GLOBALS['documentation::config'];

        if ( file_exists($templatePath) ) {
            return $this->renderTemplate(
                $template,
                [],
                View::TEMPLATE_MODE_CP
            );
        } else {
          return $this->renderTemplate(
                '_docs/404.twig',
                [],
                View::TEMPLATE_MODE_CP
            );  
        }
    }    

}
