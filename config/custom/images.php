<?php

return [

  'useWebP' => true,
  'useFallback' => true,
  'useRawSvg' => false,

  'formats' => [
    'standard' => [
      'sources' => [
        'mq768' => 'landscape',
        'mq320' => 'landscapeSmall',
        'DEFAULT' => 'landscapeMobile',
      ]
    ],
    'hero' => [
      'sizes' => ['1x'],
      'sources' => [
        'mq1440' => 'heroWide',
        'mq1024' => 'heroLarge',
        'mq768' => 'hero',
        'mq320' => 'heroMedium',
        'DEFAULT' => 'heroSmall',
      ]
    ],
    'heroFit' => [
      'sizes' => ['1x'],
      'sources' => [
        'mq1440' => 'heroFitWide',
        'mq1024' => 'heroFitLarge',
        'mq768' => 'heroFit',
        'mq320' => 'heroFitMedium',
        'DEFAULT' => 'heroFitSmall',
      ]
    ],
    'card' => [
      'sources' => [
        'mq1024' => 'card',
        'mq768' => 'cardMedium',
        'mq320' => 'cardLarge',
        'DEFAULT' => 'card',
      ]
    ],
    'square' => [
      'sources' => [
        'mq1024' => 'square',
        'mq640' => 'squareMedium',
        'DEFAULT' => 'squareSmall',
      ]
    ],
    'fit' => [
      'sources' => [
        'mq1024' => 'fitLarge',
        'mq640' => 'fitMedium',
        'DEFAULT' => 'fitSmall',
      ]
    ]

  ],

 'transforms' => [

    // Landscape/Standard Transfroms
    'landscape' => [
      'mode' => 'crop',
      'width' => 1024,
      'height' => 576,
      'quality' => 90,
    ],
    'landscapeSmall' => [
      'mode' => 'crop',
      'width' => 720 ,
      'height' => 405,
      'quality' => 90,
    ],
    'landscapeMobile' => [
      'mode' => 'crop',
      'width' => 320,
      'height' => 180,
      'quality' => 90,
    ],

    // Hero Transforms
    'heroWide' => [
      'mode' => 'crop',
      'width' => 2000,
      'height' => 1260,
      'quality' => 90,
    ],
    'heroLarge' => [
      'mode' => 'crop',
      'width' => 1440,
      'height' => 945,
      'quality' => 90,
    ],
    'hero' => [
      'mode' => 'crop',
      'width' => 1024,
      'height' => 945,
      'quality' => 90,
    ],
    'heroMedium' => [
      'mode' => 'crop',
      'width' => 768,
      'height' => 945,
      'quality' => 90,
    ],
    'heroSmall' => [
      'mode' => 'crop',
      'width' => 320,
      'height' => 945,
      'quality' => 90,
    ],

    // Hero FIT
    'heroFitWide' => [
      'mode' => 'fit',
      'width' => 2000,
      'height' => 2000,
      'quality' => 90,
    ],
    'heroFitLarge' => [
      'mode' => 'fit',
      'width' => 1440,
      'height' => 1440,
      'quality' => 90,
    ],
    'heroFit' => [
      'mode' => 'fit',
      'width' => 1024,
      'height' => 1024,
      'quality' => 90,
    ],
    'heroFitMedium' => [
      'mode' => 'fit',
      'width' => 768,
      'height' => 768,
      'quality' => 90,
    ],
    'heroFitSmall' => [
      'mode' => 'fit',
      'width' => 320,
      'height' => 320,
      'quality' => 90,
    ],

    // Card Transforms
    'card' => [
      'mode' => 'crop',
      'width' => 400,
      'height' => 350,
      'quality' => 90,
    ],
    'cardMedium' => [
      'mode' => 'crop',
      'width' => 520,
      'height' => 480,
      'quality' => 90,
    ],
    'cardLarge' => [
      'mode' => 'crop',
      'width' => 768,
      'height' => 600,
      'quality' => 90,
    ],

    // Square Transforms
    'square' => [
      'mode' => 'crop',
      'width' => 600,
      'height' => 600,
      'quality' => 90,
    ],
    'squareMedium' => [
      'mode' => 'crop',
      'width' => 480,
      'height' => 480,
      'quality' => 90,
    ],
    'squareSmall' => [
      'mode' => 'crop',
      'width' => 320,
      'height' => 320,
      'quality' => 90,
    ],

    // Product Transforms
    'fitSmall' => [
      'mode' => 'fit',
      'width' => 320,
      'height' => 320,
      'quality' => 90,
    ],
    'fitMedium' => [
      'mode' => 'fit',
      'width' => 480,
      'height' => 480,
      'quality' => 90,
    ],
    'fitLarge' => [
      'mode' => 'fit',
      'width' => 600,
      'height' => 600,
      'quality' => 90,
    ],
  ],

];