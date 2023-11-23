<?php

return [

  // Module Field Options
  // These are the options that are available for the module config field.
  'options' => [

    'backgrounds' => [
      'white' => 'White',
      'light'  => 'Salt',
      'transparent' => 'Default',
    ],

    'padding' => [
      'none'   => 'None',
      'small'  => 'Small',
      'medium' => 'Medium',
      'large'  => 'Large'
    ],

    'decorations' => [
      'brand' => 'Branded',
      'abstract' => 'Abstract',
      'bubbles' => 'Bubbles',
      'brushTop' => 'Brush Top',
      'brushBottom' => 'Brush Bottom',
      'borderTop' => 'Border Top',
      'borderBottom' => 'Border Bottom',
    ],

    'overflow' => [
      'hidden' => 'Hidden',
      'visible' => 'Visible',
    ],
  ],

  // Module Field Classes
  'values' => [
    'backgrounds' => [
      'white' => 'bg-white',
      'light' => 'bg-salt',
      'transparent' => 'bg-transparent',
    ],

    'padding' => [
      'none' => [
        'even' => '',
        'top' => '',
        'bottom' => '',
      ],
      'small' => [
        'even' => 'py-p20 mq480:py-p40 mq768:py-p80',
        'top' => 'pt-p20 mq480:pt-p40 mq768:pt-p80',
        'bottom' => 'pb-p20 mq480:pb-p40 mq768:pb-p80',
      ],
      'medium' => [
        'even' => 'py-p32 mq480:py-p48 mq768:py-p100',
        'top' => 'pt-p32 mq480:pt-p48 mq768:pt-p100',
        'bottom' => 'pb-p32 mq480:pb-p48 mq768:pb-p100',
      ],
      'large' => [
        'even' => 'py-p48 mq480:py-p64 mq768:py-p160',
        'top' => 'pt-p48 mq480:pt-p64 mq768:pt-p160',
        'bottom' => 'pb-p48 mq480:pb-p64 mq768:pb-p160',
      ]
    ],

    // Custom attributes
    'custom' => [
      'button' => [
        'white' => 'primary',
        'grey' => 'primary',
        'dark' => 'white',
        'brand' => 'white'
      ],
    ],

    'overflow' => [
      'hidden' => 'overflow-hidden',
      'visible' => 'overflow-visible',
    ]

  ],

  'headings' => [
    'levels' => [
      'h1' => 'H1',
      'h2' => 'H2',
      'h3' => 'H3',
      'h4' => 'H4',
      'h5' => 'H5',
    ],
    'sizing' => [
      'default' => 'Default',
      'h1' => 'H1',
      'h2' => 'H2',
      'h3' => 'H3',
      'h4' => 'H4',
      'h5' => 'H5',
    ]
  ],

  'layout' => [
    "backgrounds" => "white",
    "padding" => "large",
    "paddingBottom" => "large",
    "decorations" => false,
    "overflow" => 'visible',
  ],

  // Module Defaults
  'modules' => [
    'DEFAULT' => [
      'paddingClass' => '',
      'backgroundClass' => '',
    ]
    ],

  'overlap' => 'bottom',

];