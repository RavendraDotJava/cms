<?php
/**
 * ccdocsmodule module for Craft CMS 3.x
 *
 * A module for adding custom documentation to CraftCMS to improve the author experience
 *
 * @link      https://craftandcrew.ca/
 * @copyright Copyright (c) 2022 Craft&Crew
 */

namespace modules\ccdocsmodule\services;

use modules\ccdocsmodule\Ccdocsmodule;

use Craft;
use craft\base\Component;
use craft\web\View;
use \cebe\markdown\Markdown;

/**
 * CcdocsmoduleService Service
 *
 * All of your module’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other modules can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Craft&Crew
 * @package   Ccdocsmodule
 * @since     1.0,0
 */
class CcdocsmoduleService extends Component
{

    // Public Methods
    // =========================================================================

    public function getAdminUrl()
    {
        $admin = getenv('ADMIN_URL');
        if ( empty($admin) ) {
            $admin = Craft::$app->config->general->cpTrigger;
        }
        return '/' . $admin . '/';
    }


    public function getConfig()
    {
        return $GLOBALS['documentation::config'];
    }


    public function validateDocumentPath($key)
    {

        $path = '';

        // Check if path exists.
        if ( $this->validateStaticPath($key) ) {
            $path = 'documentation/' . $key;
        }

        return empty($path) ? false : $path;

    }

    public function validateStaticPath($key)
    {
        $templatePath = Craft::getAlias('@modules/ccdocsmodule') . '/docs/pages/' . $key . '.twig';
        return file_exists($templatePath);
    }


    public function getContents()
    {
        $config = $this->getConfig();
        $html = '';
        $items = [];

        // Generate items list from config.
        if ( isset($config->pages) ) {
            foreach ( $config->pages as $page => $title ) {
                $path = $this->validateDocumentPath($page);
                if ( ! empty($path) ) {
                    $items[] = (object)[
                        'title' => $title,
                        'path' => $path,
                    ];
                }
            }
        }

        // Generate $html.
        if ( ! empty($items) ) {
            $html .= '<div class="contents"><ul>';
            foreach ( $items as $item ) {
                $html .= '<li><a href="' . $this->getAdminUrl() . $item->path . '">' . $item->title . '</a></li>';
            }
            $html .= '</ul></div>';
        }
       
        return $html;
        
    }

    public function getSectionsHtml()
    {
        $html = '';
        $sections = $this->getSections();
        $config = $this->getConfig();
        if ( ! empty($config->sectionOrder) ) {
            foreach ( $config->sectionOrder as $groupHandle ) {
                if ( isset($sections[$groupHandle]) ) {
                    $title = $this->getSectionsGroupTitle($groupHandle);
                    $html .= empty($title) ? '' : '<h3>' . $title . '</h3>';
                    $html .= '<ul>';
                    foreach ( $sections[$groupHandle] as $section ) {
                        $html .= '<li><a href="' . $this->getAdminUrl() . $section['path'] . '"><span class="list-section">' . $section['name'] . '</span></a>';
                        if ( ! empty($section['description']) ) {
                            $html .= '<span> - ' . $section['description'] . '</span>';
                        }
                        $html .= $this->getTypesHtml($section);
                        $html .= '</li>';
                    }
                    $html .= '</ul>';
                }
            }
            
        }
        return $html;
    }

    public function getTypesHtml($section)
    {
        $html = '';
        if ( isset($section['types']) ) {
            if ( is_array($section['types']) ) {
                if ( count($section['types']) > 1 ) {
                    $html .= '<ul>';
                    foreach ( $section['types'] as $type ) {
                        $html .= '<li><a href="' . $this->getAdminUrl() . $type['path'] . '">' . $type['name'] . '</a>';
                        if ( ! empty($type['description']) ) {
                            $html .= '<span> - ' . $type['description'] . '</span>';
                        }                        
                        $html .= '</li>';
                    }
                    $html .= '</ul>';
                }
            }
        }
        return $html;
    }

    public function getSectionsGroupTitle($handle) {
        $title = '';
        $defaults = [
            'single' => 'Singles',
            'structure' => 'Structures',
            'channel' => 'Channels',
        ];
        if ( isset($defaults[$handle]) ) {
            return $defaults[$handle];
        } else {
            $config = $this->getConfig();
            if ( isset($config->sectionGroups[$handle]) ) {
                if ( isset($config->sectionGroups[$handle]['label']) ) {
                    return $config->sectionGroups[$handle]['label'];
                }
            }
        }
        return $title;
    }

    public function getSections()
    {
        $hierarchy = $GLOBALS['documentation::sections'];
        if ( empty($hierarchy) ) {
            $sections = Craft::$app->sections->allSections;
            foreach ( $sections as $section ) {
                $sectionType = $this->getSectionType($section);
                if ( ! isset($hierarchy[$sectionType]) ) {
                    $hierarchy[$sectionType] = [];
                } 
                array_push($hierarchy[$sectionType], $this->getSectionSectionArray($section));
            }
            foreach ( $hierarchy as &$group ) {
                usort($group, [$this, "sortSections"]);
            }
            $GLOBALS['documentation::sections'] = $hierarchy;

        }
        return $hierarchy;          
        
    }

    public function sortSections($a, $b)
    {
        return strtolower($a['id']) <=> strtolower($b['id']);
    }

    public function getSectionSectionArray($section)
    {
        $types = [];
        foreach ( $section->entryTypes as $type ) {
            array_push($types, [
                'id'   => $type->id,
                'name' => $type->name,
                'description' => $this->getTypeDescription($type),
                'path' => 'documentation/sections/' . $section->handle . '/' . $type->handle,
            ]);
        }            
        return [
            'id'   => $section->id,
            'name' => $section->name,
            'description' => $this->getSectionDescription($section),
            'path' => 'documentation/sections/' . $section->handle,
            'types' => $types,
        ];        
    }

    public function getSectionType($section)
    {
        $type = $section->type;
        $handle = $section->handle;
        $config = $this->getConfig();
        if ( isset($config->sectionGroups) ) {
            foreach ( $config->sectionGroups as $groupHandle => $group ) {
                if ( isset($group['sections']) ) {
                    if ( in_array($handle, $group['sections']) ) {
                        return $groupHandle;
                    }
                }
            }
        }
        return $type;
    }

    public function getElementsHtml($type)
    {
        $html = '';
        $contents = '';
        $elements = $this->getElements($type);
        
        $contents .= '<section class="norule"><div class="contents"><ul>';
        foreach ( $elements as $element ) { 
            $contents .= '<li><a href="#section-' . $element['handle'] . '">' . $element['name'] . '</a></li>';
            $html .= '<section id="section-' . $element['handle'] . '">';
            $html .= '<h2>' . $element['name'] . '</h2>';
            $html .= $this->renderMarkdown($element['description']);
            switch ( $element['class'] ) {

                case 'craft\models\Volume':
                    $html .= $this->assetDoc($element['handle']);                
                    break;

                case 'craft\elements\GlobalSet';
                    $html .= $this->globalDoc($element['handle']);                
                    break;
    

            }
            $html .= '</section>';
        }
        $contents .= '</ul></div></section>';

        return $contents . $html;
    }
    
    public function getElements($type)
    {
        $elements = [];
        
        switch ($type) {
            case 'assets':
                $elements = Craft::$app->volumes->allVolumes;   
                break;
            case 'globals':
                $elements = Craft::$app->globals->allSets;     
        }
        $hierarchy = [];
        foreach ( $elements as $element ) {
            array_push($hierarchy, $this->getElementArray($element));
        }
        return $hierarchy;
    }

    public function getElementArray($element)
    {
        return [
            'id'   => $element->id,
            'name' => $element->name,
            'handle' => $element->handle,
            'description' => $this->getElementDescription($element, true),
            'class' => get_class($element)
        ];
    }

    public function getCustomDescription($handle, $type = false ) {
        $config = $this->getConfig();
        $description = '';
        if ( isset($config->descriptions->$type[$handle]) ) {
            $description = $config->descriptions->$type[$handle];
        }
        return preg_replace('/\*([^\*]+)\*/', '<span class="highlight">$1</span>', $description);
    }

    public function getSectionDescription($section, $full = false)
    {

        $description = $this->getCustomDescription($section->handle, ($full ? "sectionFull" : "section"));
        
        if ( empty($description) ) {
            $format = $full ? 
                'The <span class="highlight">%s</span> section is a %s that featrues %s.' : 
                'A %s that features %s.';

            $name = $section->name;
            $type = $this->getSectionType($section);
            $count = count($section->entryTypes);
            
            $total = $count > 1 ? $count . ' different entry types' : 'a lone entry type';
            
            $description = $full ?
                sprintf($format, $section, $type, $total) : 
                sprintf($format, $type, $total);
        }

        return $description;
    }

    public function getTypeDescription($type, $full = false)
    {

        $description = $this->getCustomDescription($type->handle, ($full ? "typeFull" : "type"));
        
        if ( empty($description) ) {
            
            $format = $full ? 
                'The <span class="highlight">%s</span> entry type belongs to the <span class="highlight">%s</span> section.' : 
                '';

            $section = $type->section;
            $name = $type->name;
            $sectioName = $section->name;
                    
            $description = $full ?
                sprintf($format, $name, $sectioName) : 
                $format;
        
        }

        return $description;
    }

    public function getElementDescription($element, $full = false)
    {

        $handle = $element->handle;
        $descTypes = [];
        $description = '';
        switch ( get_class($element) ) {

            case 'craft\models\Volume':
                $descTypes = ['assetFull', 'asset'];
                $format = $full ? 
                    'The <span class="highlight">%s</span> volume contains the following fields %s' : 
                    '';                
                break;

            case 'craft\elements\GlobalSet';
                $descTypes = ['globalFull', 'global'];
                $format = $full ? 
                    'The <span class="highlight">%s</span> global set contains the following fields %s' : 
                    '';                
                break;    

        }

        $description = $this->getCustomDescription($handle, ($full ? $descTypes[0] : $descTypes[1]));

        if ( ! empty($descTypes) && empty($description) ) {

            $count = count($element->getFieldLayout()->tabs);
            $total = $count > 1 ? 'divided across ' . $count . ' different tabs:' : 'in a single collection:';
            
            $description = $full ?
                sprintf($format, $element->name, $total) : 
                sprintf($format, $element->name);

        }

        return $description;
    } 
    
    public function getSeoFieldName()
    {
        $name = 'SEO';
        $config = $this->getConfig();
        if ( ! empty($config->seoFieldObject) ) {
            $name = $config->seoFieldObject->name;
        }
        return $name;
    }

    public function getSeoFieldContents()
    {
        $html = '';
        $robots = false;
        $config = $this->getConfig();
        $seoGroupCount = 0;
        $seoGroups = [
            'generalTabEnabled' => [
                'enabled' => false,
                'name' => 'General Tab',
                'group' => 'generalEnabledFields'
            ],
            'twitterTabEnabled' => [
                'enabled' => false,
                'name' => 'Twitter Tab',
                'group' => 'twitterEnabledFields'
            ],
            'facebookTabEnabled' => [
                'enabled' => false,
                'name' => 'Facebook Tab',
                'group' => 'facebookEnabledFields'
            ],
            'sitemapTabEnabled' => [
                'enabled' => false,
                'name' => 'Sitemap Tab',
                'group' => 'sitemapEnabledFields'
            ],
        ];

        if ( ! empty($config->seoFieldObject) ) {

            foreach ( $seoGroups as $groupKey => $group ) {
                if ( $config->seoFieldObject->$groupKey ) {
                    $seoGroupCount += 1;
                    $seoGroups[$groupKey]['enabled'] = true;
                }
            }

            $html .= '<p>This site’s configuration allows us to define overrides for the following values in the SEO field:</p>';
            foreach ( $seoGroups as $groupKey => $group ) {
                if ( $group['enabled'] ) {
                    $groupFieldsKey = $group['group'];
                    if ( is_array($config->seoFieldObject->$groupFieldsKey) ) {                 
                        if ( $seoGroupCount > 1 ) {
                            $html .= '<h3>' . $group['name'] . '</h3>';
                        }
                        $html .= '<ul>';
                        foreach ($config->seoFieldObject->$groupFieldsKey as $field) {
                            $html .= '<li><span class="highlight">' . $this->getSeoSubfieldName($field) . '</span></li>';
                            if ( $field === 'robots' ) {
                                $robots = true;
                            }
                        } 
                        $html .= '</ul>';
                    }
                }
            }
            $html .= '<p>To apply an override, activate the appropriate switch. For any of the "Source" fields, you can add a custom value or select a field from which to pull data.</p>';
            if ( $robots ) {
                $html .= '<p>The <span class="highlight">Robots</span> field is somewhat different and allows you to define the robots meta tag to help instruct search bots on how to index the page.</p>';
            }
        }
        return $html;
    }

    public function getSeoSubfieldName($field)
    {
        $label = $field;
        $labels = [
            'seoPreview' => 'SEO Preview',
            'mainEntityOfPage' => 'Main Entity of Page',
            'seoTitle' => 'SEO Title',
            'siteNamePosition' => 'Site Name Position',
            'seoDescription' => 'SEO Description',
            'seoKeywords' => 'SEO Keywords',
            'seoImage' => 'SEO Image',
            'seoImageTransform' => 'Transform SEO Image',
            'seoImageTransformMode' => 'SEO Image Transform Mode',
            'seoImageDescription' => 'SEO Image Description',
            'robots' => 'Robots', 
            'canonicalUrl' => 'Canonical URL',

            // Twitter
            'twitterCardType' => 'Twitter Card Type',
            'twitterCreator' => 'Twitter Creator',
            'twitterTitle' => 'Twitter Title',
            'twitterSiteNamePosition' => 'Twitter Site Name Position',
            'twitterDescription' => 'Twitter Description',
            'twitterImage' => 'Twitter Image',
            'transformTwitterImage' => 'Transform Twitter Image',
            'twitterImageTransformMode' => 'Twitter Image Transform Mode',
            'twitterImageDescription' => 'Twitter Image Description',

            // Facebook
            'ogType' => 'Facebook OpenGraph Type',
            'ogTitle' => 'Facebook OpenGraph Title',
            'ogSiteNamePosition' => 'Facebook OpenGraph Site Name Position',
            'ogDescription' => 'Facebook OpenGraph Description',
            'ogImage' => 'Facebook OpenGraph Image',
            'ogImageTransform' => 'Transform Facebook OpenGraph Image',
            'ogImageTransformMode' => 'Facebook OpenGraph Image Transform Mode',
            'ogImageDescription' => 'Facebook OpenGraph Image Description',

            // Sitemap
            'sitemapUrls' => 'Sitemap Enabled',
            'sitemapAssets' => 'Include Images & Videos in Sitemap',
            'sitemapFiles' => 'Include Indexable Files in Sitemap',
            'sitemapAltLinks' => 'Sitemap Alt URLs',
            'sitemapChangeFreq' => 'Change Frequency',
            'sitemapPriority' => 'Priority',
            'sitemapLimit' => 'Sitemap Limit',

        ];
        if ( isset($labels[$field]) ) {
            $label = $labels[$field];
        }
        return $label;
    }

    public function getSocialProfiles()
    {
        $html = '';
        $profiles = [];
        if ( isset(Craft::$app->config->custom->ccSocialProfiles) ) {
            $profiles = Craft::$app->config->custom->ccSocialProfiles;
        }
        if ( ! empty($profiles) ) {
            $html .= '<ul>';
            foreach ( $profiles as $profile => $label ) {
                $html .= '<li><span class="highlight">' . $label . '</span></li>';
            }
            $html .= '</ul>';
        } else {
            $html .= '<p><span class="highlight">No social profiles are available.</span></p>';
        }
        return $html;
    }


    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin/module file, call it like this:
     *
     *     Ccdocsmodule::$instance->ccdocsmoduleService->entryTypeDoc()
     *
     * @return mixed
     */
    public function entryTypeDoc($type, $warning = false, $heading = 'h2')
    {
        $entryTypes = Craft::$app->sections->getEntryTypesByHandle($type);
        return $this->getFieldLayout($entryTypes[0], $warning, $heading);
    }

    public function globalDoc($global, $warning = false, $heading = 'h2')
    {
        $globalSet = Craft::$app->globals->getSetByHandle($global);
        return $this->getFieldLayout($globalSet, $warning, $heading);
    }

    public function assetDoc($volume, $warning = false, $heading = 'h2')
    {
        $volumeSet = Craft::$app->volumes->getVolumeByHandle($volume);
        return $this->getFieldLayout($volumeSet, $warning, $heading);
    }

    public function getFieldLayout($layout, $warning = false, $heading = 'h2')
    {

        $html = '';
        $tabs = $layout->getFieldLayout();
        $tabs = $tabs->tabs;
        $count = count($tabs);

        if ( $count > 1 ) {
            $html .= '<div class="section"><div class="contents">';
            $html .= '<ul>';
            foreach ( $tabs as $tab ) {
                $html .= '<li><a href="#tab-' . $tab->id . '">' . $tab->name . '</a></li>';
            }
            $html .= '</ul>';
            $html .= '</div></div>';
        }

        if ( $warning ) {
            $html .= '';
        }

        foreach ( $tabs as $tab ) {
            $items = $tab->elements;       
            
            // Start the field list
            $html .= '<div class="section" id="tab-' . $tab->id . '">';
            if ( $count > 1 ) {
                $html .= "<$heading>" . $tab->name . "</$heading>";
            }
            $html .= '<ul>';

            foreach ( $items as $item ) {

                $class = get_class($item);

                [$name, $instructions, $context, $field] = $this->parseValuesFromClass($class, $item, 'root');

                $html .= $this->getFieldItemEntry($field, $name, $instructions, $context);
            }

            // End the field list
            $html .= '</ul>';
            $html .= '</div>';

        }  

        return $html;

    }


    public function getFieldItemEntry($field, $name = null, $instructions = null, $context = null) {

        $config = $this->getConfig();
        $class = is_array($field) ? $field['type'] : get_class($field);
        $classSegments = explode('\\', $class);
        $classLength = count($classSegments);

        if ( $context === null ) {
            $context = $classSegments[$classLength-1];
        } else {
            $context = $classSegments[$classLength-1] . "; " . $context;
        }

        if ( $name === null || $name === '') { $name = (isset($field->name)) ? $field->name : ''; }
        if ( $instructions === null || $instructions === '' ) { 
            $instructions = (isset($field->instructions)) ? $field->instructions : '';
        } 
        if ( empty($instructions) && $config->devMode ) {
            $instructions = '<span class="todo">TO DO: WRITE INSTRUCTIONS FOR THIS FIELD</span>';
        }

        $html = ( $name === '__null__') ? '<li class="hr">' : '<li>';
        if ( $name !== '__null__' ) {
            $html .= '<span class="highlight">' . $name . '</span> <span class="type">(' . $context . ')';
            $html .= $this->getFieldTypeLink($context);
            $html .= '</span>';
        }
        $html .= Craft::$app->getView()->renderTemplate(
            'ccdocsmodule/_components/documentation/instructions',
            [
                'instructions' => $instructions
            ]
        );

        // Expand Matrix Options
        if ( $class === 'craft\fields\Matrix' ) {

            $blocks = $field->blockTypes;
            $html .= '<ul class="blocks">';
            foreach ( $blocks as $block ) {
                
                $subFields = $block->behaviors['fieldLayout']->fieldLayout->customFields;

                $html .= '<li class="block">';
                $html .= '<div class="block__heading"><p class="h3">MATRIX BLOCK : <span class="highlight">' . $block->name . '</span></p></div>';
                $html .= '<div class="block__body">';
                if ( ! empty($subFields) ) {
                    $html .= 'This block contains the following fields:';
                    $html .= '<ul>';

                    foreach ( $subFields as $subField ) {

                        $html .= $this->getFieldItemEntry($subField);
                    }                

                    $html .= '</ul>';
                }
                $html .= '</div>';
                $html .= '</li>'; 
            }
            $html .= '</ul>';
        }

        // Expand SuperTable Options
        if ( $class === 'verbb\supertable\fields\SuperTableField' ) {

            $subFields = $field->blockTypes[0]->behaviors['fieldLayout']->fieldLayout->customFields;

            $html .= '<p>This repeating field contains the following sub-fields:</p>';
            $html .= '<ul>';
            
            foreach ( $subFields as $subField ) {

                $html .= $this->getFieldItemEntry($subField);
            }                

            $html .= '</ul>';              

        }

        // Expand Vizy Options
        if ( $class === 'verbb\vizy\fields\VizyField') {

            if ( ! empty($field->fieldData) ) {

                $groups = $field->fieldData;

                $html .= '<p>This Vizy field contains the following blocks</p>';
                $html .= '<ul class="blocks">';

                foreach ( $groups as $group ) {

                    $blocks = $group['blockTypes'];

                    foreach ( $blocks as $block ) {

                        $html .= ( $name === '__null__') ? '<li class="hr">' : '<li class="block">';
                        if ( $block['name'] !== '__null__' ) {
                            $html .= '<div class="block__heading"><p class="h3">Content Block: <span class="highlight">' . $block['name'] . '</span> <span class="type">(Part of ' . $group['name'] . ' group)</p></div>';
                        }
                        $html .= '<div class="block__body">';
                        $html .= '<p>This content block contains the following fields:</p>';

                        $html .= '<ul>';
                        $tabs = $block['layoutConfig']['tabs'];

                        foreach ($tabs as $tab) {
                            $elements = $tab['elements'];
                            foreach ( $elements as $element ) {
                                $subClass = is_array($element) ? $element['type'] : get_class($element);
                                [$name, $instructions, $context, $subField] = $this->parseValuesFromClass($subClass, $element, 'vizy');
                                $context = 'Under the ' . $tab['name'] . ' tab';
                                $html .= $this->getFieldItemEntry($subField, $name, $instructions, $context);
                            }
                        }

                        $html .= '</ul>';
                        $html .= '</div>';
                        $html .= '</li>';
                    }
                    
                }                

                $html .= '</ul>';                   

            }

        }        

        $html .= '</li>';

        return $html;
        
    }

    public function parseValuesFromClass($class, $item, $source)
    {

        if ( $class === 'craft\fieldlayoutelements\entries\EntryTitleField') {
            $name = ( ! empty($item->label ) ) ? $item->label : 'Title';
            $instructions = ( ! empty($item->instructions ) ) ? $item->instructions : 'Use this field to set the title for this entry. The page heading (h1) and SEO title can be set in separate fields. If not, the value of this field will be used.';
            $context = null;
            $field = $item;                         
        } else if ( $class === 'craft\fieldlayoutelements\assets\AssetTitleField' ) {
            $name = ( ! empty($item->label ) ) ? $item->label : 'Title';
            $instructions = ( ! empty($item->instructions ) ) ? $item->instructions : 'Use this field to set the title for this asset. This value is automatically determined based on the filename that was uploaded, but can be modified as appropriate. Changing the title does *not* change the filename.';
            $context = null;
            $field = $item;  
        } else if ( $class === 'craft\fieldlayoutelements\assets\AltField' ) {
            $name = ( ! empty($item->label ) ) ? $item->label : 'Alternative Text';
            $instructions = ( ! empty($item->instructions ) ) ? $item->instructions : 'Use this field to add alternative text to this asset.';
            $context = null;
            $field = $item;              
        } else if ( $class === 'craft\fieldlayoutelements\Heading' ) {
            $_heading = ( $source === 'vizy' ) ? $item['heading'] : $item->heading;
            $name = 'UI: Heading';
            $instructions = '<p>This UI component will render a custom heading within the field layout. Here is an example of its rendering:</p><p class="h2">' . $_heading . '</p>';
            $context = null;
            $field = $item;                    
        } else if ( $class === 'craft\fieldlayoutelements\Tip' ) {
            $_style = ( $source === 'vizy' ) ? $item['style'] : $item->style;
            $_tip = ( $source === 'vizy' ) ? $item['tip'] : $item->tip;
            $name = $_style === 'warning' ? 'UI: Warning' : 'UI: Tip';
            $instructions = '<p>This UI component will render a block like this:</p><div class="readable"><blockquote class="note ' . $_style . '">' . $_tip . '</blockquote></div>';
            $context = null;
            $field = $item;
        } else if ( $class === 'craft\fieldlayoutelements\Template' ) {
            $_template = ( $source === 'vizy' ) ? $item['template'] : $item->template;
            $name = 'UI: Custom Template';
            $instructions = '<p>This UI component will render the custom template <span class="highlight">' . $_template . '</span>. Here is an example of its rendering:</p><div class="template">' . Craft::$app->getView()->renderTemplate($_template,[], View::TEMPLATE_MODE_SITE) . '</div>';
            $context = null;
            $field = $item;
        } else if ( $class === 'craft\fieldlayoutelements\HorizontalRule' ) {
            $name = '__null__';
            $instructions = '<hr>';
            $context = null;
            $field = $item;                                       
        } else {
            if ( $source === 'vizy' ) {
                $field = Craft::$app->fields->getFieldByUid($item['fieldUid']);
                $name = $this->existsInArray($item, 'label') ? $item['label'] : $field->name;
                $instructions = $this->existsInArray($item, 'instructions') ? $item['instructions'] : $field->instructions;
                $context = '';
            } else {
                $name = $item->label;
                $instructions = $item->instructions;
                $context = null;
                $field = isset($item->field) ? $item->field : (object)array();
            }
        }

        return [
            $name, $instructions, $context, $field
        ];

    }

    public function getFieldTypeLink($context) 
    {
        $html = '';
        $config = $this->getConfig();
        $segments = explode(';', $context);

        if ( isset($config->fields) ) {
            if ( isset($config->fields[$segments[0]]) ) {
                $html = '<a class="field-doc" href="' . $this->getAdminUrl() . 'documentation/fields/' . $config->fields[$segments[0]]['handle'] . '" title="Learn more about the ' . $config->fields[$segments[0]]['label'] . ' field"><span class="hidden">' . $segments[0] . '</span>';
                $html .= '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-0.5 -0.5 14 14" height="14" width="14"><g id="expand-window-2--expand-small-bigger-retract-smaller-big"><path stroke-linecap="round" stroke-linejoin="round" d="M12.535714285714286 7.428571428571429v4.178571428571429c0 0.24625714285714287 -0.09787142857142857 0.48248571428571424 -0.27197857142857146 0.6565928571428571s-0.4103357142857143 0.27197857142857146 -0.6565928571428571 0.27197857142857146h-10.214285714285715c-0.2462757142857143 0 -0.48245785714285716 -0.09787142857142857 -0.6565993571428572 -0.27197857142857146C0.5621172142857144 12.089628571428573 0.4642857142857143 11.8534 0.4642857142857143 11.607142857142858v-10.214285714285715c0 -0.2462757142857143 0.09783150000000002 -0.48245785714285716 0.27197207142857144 -0.6565993571428572C0.9103992857142857 0.5621172142857144 1.1465814285714286 0.4642857142857143 1.3928571428571428 0.4642857142857143H5.571428571428571" stroke-width="1"></path><path id="Vector_2" stroke-linecap="round" stroke-linejoin="round" d="M9.285714285714286 0.4642857142857143h3.25V3.7142857142857144" stroke-width="1"></path><path id="Vector_3" stroke-linecap="round" stroke-linejoin="round" d="M12.535714285714286 0.4642857142857143 6.5 6.5" stroke-width="1"></path></g></svg>';
                $html .= '</a>';
            }
        }

        return $html;
    }

    public function getFieldContents()
    {
        $config = $this->getConfig();
        $html = '';

        if ( isset($config->fields ) ) {
        $html .= '<div class="contents"><ul>';
        foreach ( $config->fields as $field ) {
            $templatePath = Craft::getAlias('@modules/ccdocsmodule') . '/docs/fields/' . $field['handle'] . '.twig';
            if ( file_exists($templatePath) ) {
                $html .= '<li><a href="/admin/documentation/fields/' . $field['handle'] . '">' . $field['label'] . '</a></li>';
            }
        }
        $html .= '</ul></div>';
        }

        return $html;
    }

    public function getDocumentationImage($file, $alt = '')
    {
        $url = \Craft::$app->assetManager->getPublishedUrl(
            '@modules/ccdocsmodule/assetbundles/ccdocsmodule/dist/img',
            true,
            $file
        );
        return '<img class="screenshot" src="' . $url . '">';
    }

    public function existsInArray($array, $key) 
    {
        if ( isset($array[$key]) ) {
            if ( ! empty($array[$key]) ) {
                return true;
            }
        }
        return false;
    }

    public static function renderMarkdown($content)
    {
        $parser = new Markdown();
        return $parser->parse($content);
    }

}