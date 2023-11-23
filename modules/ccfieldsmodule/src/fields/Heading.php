<?php
/**
 * CCFields module for Craft CMS 3.x
 *
 * Module Field
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2021 Craft&Crew
 */

namespace modules\ccfieldsmodule\fields;

use modules\ccfieldsmodule\CCFieldsModule;
use modules\ccfieldsmodule\assetbundles\heading\HeadingFieldAsset;
use modules\cchelpersmodule\models\ModuleConfig;
use modules\ccfieldsmodule\models\Heading as HeadingModule;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * Instructions Field
 *
 * Whenever someone creates a new field in Craft, they must specify what
 * type of field it is. The system comes with a handful of field types baked in,
 * and we’ve made it extremely easy for modules to add new ones.
 *
 * https://craftcms.com/docs/plugins/field-types
 *
 * @author    Craft&Crew
 * @package   CCFieldsModule
 * @since     1.0.0
 */
class Heading extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * Some attribute
     *
     * @var string
     */
    public $heading = '';

    public $levels = [];
    public $levelDefault = 'h2';

    public $sizing = [];
    public $sizingDefault = '';

    public $defaults = [
      'levels' => [
        'h1' => 'H1',
        'h2' => 'H2',
        'h3' => 'H3',
        'h4' => 'H4',
      ],
      'sizing' => [
        'default' => 'Default',
        'h1' => 'H1',
        'h2' => 'H2',
        'h3' => 'H3',
        'h4' => 'H4',
        'h5' => 'H5',
      ]
      ];

    // Static Methods
    // =========================================================================

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('ccfields-module', 'Heading');
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return $rules;
    }

    /**
     * Returns the column type that this field should get within the content table.
     *
     * This method will only be called if [[hasContentColumn()]] returns true.
     *
     * @return string The column type. [[\yii\db\QueryBuilder::getColumnType()]] will be called
     * to convert the give column type to the physical one. For example, `string` will be converted
     * as `varchar(255)` and `string(100)` becomes `varchar(100)`. `not null` will automatically be
     * appended as well.
     * @see \yii\db\QueryBuilder::getColumnType()
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * Normalizes the field’s value for use.
     *
     * This method is called when the field’s value is first accessed from the element. For example, the first time
     * `entry.myFieldHandle` is called from a template, or right before [[getInputHtml()]] is called. Whatever
     * this method returns is what `entry.myFieldHandle` will likewise return, and what [[getInputHtml()]]’s and
     * [[serializeValue()]]’s $value arguments will be set to.
     *
     * @param mixed                 $value   The raw field value
     * @param ElementInterface|null $element The element the field is associated with, if there is one
     *
     * @return mixed The prepared field value
     */
    public function normalizeValue(mixed $value, ?craft\base\ElementInterface $element = null): mixed
    {

      if ( $this->is_json($value) ) {
        if ( Craft::$app->request->getIsSiteRequest() ) {
          return new HeadingModule(Json::decode($value));
        }
        return Json::decode($value);
      } else {
        if ( Craft::$app->request->getIsSiteRequest() ) {
          return new HeadingModule($value);
        }
        return $value;
      }

      return $value;
    }

    public function is_json($string){
      return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    /**
     * Prepares the field’s value to be stored somewhere, like the content table or JSON-encoded in an entry revision table.
     *
     * Data types that are JSON-encodable are safe (arrays, integers, strings, booleans, etc).
     * Whatever this returns should be something [[normalizeValue()]] can handle.
     *
     * @param mixed $value The raw field value
     * @param ElementInterface|null $element The element the field is associated with, if there is one
     * @return mixed The serialized field value
     */
    public function serializeValue(mixed $value, ?craft\base\ElementInterface $element = null): mixed
    {
        return parent::serializeValue($value, $element);
    }


    public function getModuleConfig()
    {
        $config = Craft::$app->getConfig()->getConfigFromFile('modules');
        $options = array_merge($this->defaults, (isset($config['headings']) ? $config['headings'] : []) );
        return $options;
    }

    /**
     * Returns the component’s settings HTML.
     *
     * @return string|null
     */
    public function getSettingsHtml(): ?string
    {

        $config = $this->getModuleConfig();

        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'ccfields-module/_components/fields/Heading_settings',
            [
                'field' => $this,
                'levels' => $config['levels'],
                'levelsOptions' => $this->levels,
                'levelDefault' => $this->levelDefault,
                'sizing' => $config['sizing'],
                'sizingOptions' => $this->sizing,
                'sizingDefault' => $this->sizingDefault,
            ]
        );
    }

    /**
     * Returns the field’s input HTML.
     *
     * @param mixed                 $value           The field’s value. This will either be the [[normalizeValue() normalized value]],
     *                                               raw POST data (i.e. if there was a validation error), or null
     * @param ElementInterface|null $element         The element the field is associated with, if there is one
     *
     * @return string The input HTML.
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        Craft::$app->getView()->registerAssetBundle(HeadingFieldAsset::class);

        // Get our modules config.
        $config = $this->getModuleConfig();

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').CCFieldsModuleModule(" . $jsonVars . ");");

        // Set the background values;
        $levels = [];
        if ( ! empty($this->levels) ) {
          foreach ($this->levels as $val) {
            if ( isset($config['levels'][$val]) ) {
              $levels[$val] = $config['levels'][$val];
            }
          }
        }

        // Set the sizing values;
        $sizing = [];
        if ( ! empty($this->sizing) ) {
          foreach ($this->sizing as $val) {
            if ( isset($config['sizing'][$val]) ) {
              $sizing[$val] = $config['sizing'][$val];
            }
          }
        }

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'ccfields-module/_components/fields/Heading_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'levelsOptions' => $levels,
                'levelDefault' => $this->levelDefault,
                'sizingOptions' => $sizing,
                'sizingDefault' => $this->sizingDefault,
            ]
        );
    }

}
