<?php
/**
 * Dynamic Dropdowns plugin for Craft CMS 3.x
 *
 * Populate a Dropdown field with options from a Global.
 *
 * @link      https://soshal.ca
 * @copyright Copyright (c) 2018 Soshal
 */

namespace modules\ccfieldsmodule\fields;

use modules\ccfieldsmodule\CCFieldsModule;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\fields\BaseOptionsField;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Soshal
 * @package   PresetDropdowns
 * @since     1.0.0
 */
class PresetDropdown extends BaseOptionsField
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $sourceGlobal;
    public $sourceLabelHandle = 'label';
    public $sourceValueHandle = 'value';
    public $newLabelFormat = '{{ label }}';

    
    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('ccfields-module', 'Preset Dropdown');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {

        parent::__construct($config);
        $this->options = self::getOptionsFromConfig($this->sourceGlobal, $this->sourceLabelHandle, $this->sourceValueHandle, $this->newLabelFormat);

    }  

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue(mixed $value, ?craft\base\ElementInterface $element = null): mixed
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue(mixed $value, ?craft\base\ElementInterface $element = null): mixed
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'ccfields-module/_components/fields/PresetDropdown_settings',
            [
                'field' => $this,
                'globals' => self::getPresets(),
                'sourceGlobal' => $this->sourceGlobal,
                'sourceLabelHandle' => $this->sourceLabelHandle,
                'sourceValueHandle' => $this->sourceValueHandle,
                'newLabelFormat' => $this->newLabelFormat
            ]
        );
    }

    public function isValueEmpty($value, ElementInterface $element): bool
    {

        /** @var MultiOptionsFieldData|SingleOptionFieldData $value */
        if ($value instanceof SingleOptionFieldData) {
            return $value->value === null || $value->value === '';
        }
 
        return empty($value);

    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);
        // $options = self::getOptionsFromConfig($this->sourceGlobal, $this->sourceLabelHandle, $this->sourceValueHandle, $this->newLabelFormat);
        $options = $this->options;

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            'options' => $options
            ];
        $jsonVars = Json::encode($jsonVars);


        // Render the input template
        $html = Craft::$app->getView()->renderTemplate(
            'ccfields-module/_components/fields/PresetDropdown_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'options' => $options,
            ]
        );

        return $html;
    }


    // Get a list of Global fields as dropdown options
    protected function getPresets()
    {
        $dropdownList = [];
        $drowdownSets = Craft::$app->getConfig()->getConfigFromFile('custom/presets');
        if ( isset($drowdownSets) ) {
            
            foreach ($drowdownSets as $index => $drowdownSet) {
                
                array_push($dropdownList, array(
                    'label' => $drowdownSet['name'],
                    'value' => $index,
                ));

            }
        
        }

        return $dropdownList;
    }

    // Get a list of the selected Global's values as dropdown options
    public static function getOptionsFromConfig($id_handle, $label, $value, $newLabelFormat)
    {
        $options = array();

        $config = Craft::$app->getConfig()->getConfigFromFile('custom/presets');
        if ( isset($config[$id_handle]) ) {

            $preset = $config[$id_handle];
            $values = $preset['values'];
            
            foreach( $values as $key => $value ) {
                array_push($options, array(
                    'label' => $value,
                    'value' => $key,
                ));                
            }

        }        

        return $options;
    }    

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function optionsSettingLabel(): string
    {
        return Craft::t('app', 'Dropdown Options');
    }
}
