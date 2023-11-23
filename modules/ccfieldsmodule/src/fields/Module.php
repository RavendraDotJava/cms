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
use modules\ccfieldsmodule\assetbundles\modulefield\ModuleFieldAsset;
use modules\ccfieldsmodule\models\ModuleConfig;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * Module Field
 *
 * A common pattern in our modular site builds is to build a matrix field with each
 * block representing a unique module. Within those individual blocks, certain common
 * fields are often required. The Module field can be used to standardize the experience,
 * while providing some level of flexibility to content editors on a module-by-module basis.
 *
 * https://craftcms.com/docs/plugins/field-types
 *
 * @author    Craft&Crew
 * @package   CCFieldsModule
 * @since     1.0.0
 */
class Module extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * Module ID
     *
     * @var string
     */
    public $moduleId = '';


    /**
     * Backgrounds array
     * Contains the background options available for this field.
     *
     * @var array
     */
    public $backgrounds = [];


    /**
     * Backgrounds default
     * Defines the initial background option when the field is first initialized.
     *
     * @var string
     */
    public $backgroundsDefault = '';


    /**
     * Padding array
     * Contains the padding options available for this field.
     *
     * @var array
     */
    public $padding = [];


    /**
     * Padding default
     * Defines the initial padding option when the field is first initialized.
     *
     * @var string
     */
    public $paddingDefault = '';


    /**
     * Decorations array
     * Contains the decoration options available for this field.
     *
     * @var array
     */
    public $decorations = [];


    /**
     * Backgrounds default
     * Defines the initial decoration option when the field is first initialized.
     *
     * @var string
     */
    public $decorationsDefault = '';


    /**
     * Indedpendent Padding
     * Determines whether top and bottom padding should be determined independently
     *
     * @var boolean
     */
    public $independentPadding = false;

    /**
     * Overflow array
     * Contains the overflow options available for this field.
     *
     * @var array
     */
    public $overflow = [];


    /**
     * Module Defaults array
     * Contains some basic module defaults (empty arrays).
     *
     * @var array
     */
    public $moduleDefaults = [
      'backgrounds' => [],
      'padding' => [],
      'decorations' => [],
      'overflow' => [],
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
        return Craft::t('ccfields-module', 'Module Settings');
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
        return $value;
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
        $config = new ModuleConfig();
        $options = array_merge($this->moduleDefaults, $config->config['options']);
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
        Craft::$app->getView()->registerAssetBundle(ModuleFieldAsset::class);

        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'ccfields-module/_components/fields/Module_settings',
            [
                'field' => $this,
                'backgrounds' => $config['backgrounds'],
                'backgroundValues' => $this->backgrounds,
                'backgroundDefault' => $this->backgroundsDefault,
                'padding' => $config['padding'],
                'paddingValues' => $this->padding,
                'paddingDefault' => $this->paddingDefault,
                'decorations' => $config['decorations'],
                'decorationsValues' => $this->decorations,
                'independentPadding' => $this->independentPadding,
                'overflow' => $config['overflow'],
                'overflowValues' => $this->overflow,
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

        if ( empty($value) ) {
          $value = '{}';
        }

        Craft::$app->getView()->registerAssetBundle(ModuleFieldAsset::class);

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
        $backgrounds = [];
        if ( ! empty($this->backgrounds) ) {
          foreach ($this->backgrounds as $val) {
            if ( isset($config['backgrounds'][$val]) ) {
              $backgrounds[$val] = $config['backgrounds'][$val];
            }
          }
        }

        // Set the padding values;
        $padding = [];
          if ( ! empty($this->padding ) ) {
          foreach ($this->padding as $val) {
            if ( isset($config['padding'][$val]) ) {
              $padding[$val] = $config['padding'][$val];
            }
          }
        }

        // Set the padding values;
        $decorations = [];
        if ( ! empty($this->decorations ) ) {
          $decorations['none'] = 'None';
          foreach ($this->decorations as $val) {
            if ( isset($config['decorations'][$val]) ) {
              $decorations[$val] = $config['decorations'][$val];
            }
          }
        }

        // Set the overflow values;
        $overflow = [];
          if ( ! empty($this->overflow ) ) {
          foreach ($this->overflow as $val) {
            if ( isset($config['overflow'][$val]) ) {
              $overflow[$val] = $config['overflow'][$val];
            }
          }
        }


        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'ccfields-module/_components/fields/Module_input',
            [
                'name' => $this->handle,
                'value' => Json::encode($value),
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'backgrounds' => $backgrounds,
                'backgroundDefault' => $this->backgroundsDefault,
                'padding' => $padding,
                'paddingdDefault' => $this->paddingDefault,
                'decorations' => $decorations,
                'independentPadding' => $this->independentPadding,
                'overflow' => $overflow
            ]
        );
    }

}
