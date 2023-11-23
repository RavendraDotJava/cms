<?php 

return [

  'useDocumentation' => true,
  
  'pages' => [
    'modular-content' => 'Modular Content',
    'fields' => 'Fields',
    'sections' => 'Sections & Entries',
    'globals' => 'Globals',
    'assets' => 'Assets',
    'navigation' => 'Navigation',
    'seo' => 'SEO',
    'accessibility' => 'Accessibility',
    'video-training' => 'Video Training',

  ],

  'sectionOrder' => [
    'single',
    'structure',
    'channel',
    'fragment',
    'taxonomy',
  ],

  'sectionGroups' => [
    'fragment' => [
      'label' => 'Fragments',
      'sections' => [
        'testimonials',
        'cta'
      ]
    ],
    'taxonomy' => [
      'label' => 'Taxonomies',
      'sections' => [
        'categories',
      ]
    ]    
  ],

  'fields' => [
    'Heading' => [
      'handle' => 'heading',
      'label' => 'Heading',
    ],
    'Module'  => [
      'handle' => 'module',
      'label' => 'Module',
    ],
    'Matrix'  => [
      'handle' => 'matrix',
      'label' => 'Matrix',
    ],
    'LinkField'  => [
      'handle' => 'entrylink',
      'label' => 'Entry Link',
    ],
    'VizyField'  => [
      'handle' => 'richtext',
      'label' => 'Rich Text',
    ],
  ],

  'seoField' => 'seoSettings',

  'devUser' => 'admin',

];