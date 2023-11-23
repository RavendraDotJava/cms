<?php

return [

  // CUSTOM SETTINGS ----------------------------------------------------------------------------------------------- //
  // The following settings are custom values added to the General config. They are not expected or used by Craft's core functionality,
  // and are used only by the custom modules packages with this build.

  'ccFieldsInstructions' => true,
  'ccPresetDropdowns' => true,
  'ccFieldsIcon' => true,
  'ccFieldIconsSvgPath' => 'dist/icons.svg',

  // This setting allows us to define the specific folders that are checked for site-specific site includes using the |siteInclude filter.
  // This allows us to:
  //  - Provide simplified folders when sites might have longer handles
  //  - Apply the same folder to multiple sites, which is useful if we have multilingual requirements on a site that supports different site groups.
  // The array key should be equal to the handle for a given site.
  // The array value should be equal to the folder we want to represent.
  'ccSiteIncludePaths' => [
      'default' => 'default'
  ],

  // Preset dropdowns allow us to define a preset collections of options to be used in present dropdown fields.
  'presetDropdowns' => [
      'alignment' => [
          'name' => 'Alignment',
          'values' => [
              'left' => 'Left',
              'center' => 'Center',
              'right' => 'Right',
          ]
      ],
      'videos' => [
          'name' => 'Video Types',
          'values' => [
              'youtube' => 'YouTube',
              'vimeo' => 'Vimeo',
          ]
      ],
      'widths' => [
          'name' => 'Widths',
          'values' => [
              'max-w-p768' => 'Small',
              'max-w-p1024' => 'Medium',
              'max-w-p1280' => 'Large',
              'max-w-p1440' => 'Wide',
          ]
      ]
  ],

];