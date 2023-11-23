<?php
return [
  // Custom  palettes, fixed options [label, default (boolean), colour (array(colour, customOptions)) ]
  'palettes' => [

    'Olina' => [  // custom label (required)
      [
        'label'   => 'Bark', // custom label (required)
        'default' => true,  // default could be true/false (option is required)
        'color'   =>  [
          [
            'color' => '#E0A769', // the colour shown in the fieldtype (required)
            'background' => 'bg-bark',
          ]
        ]
      ],
      [
        'label'   => 'Ryegrass',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#BCB385',
            'background' => 'bg-ryegrass',
          ]
        ]
      ],
      [
        'label'   => 'Hanana',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#A4A887',
            'background' => 'bg-hanana',
          ]
        ]
      ],
      [
        'label'   => 'Terracotta',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#EBC09F',
            'background' => 'bg-terracotta',
          ]
        ]
      ],
      [
        'label'   => 'Palenka',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#6B98AD',
            'background' => 'bg-palenka',
          ]
        ]
      ],
      [
        'label'   => 'Kilohana',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#E19480',
            'background' => 'bg-kilohana',
          ]
        ]
      ]
    ],

    'Olina Secondary' => [
      [
        'label'   => 'Palenka',
        'default' => true,
        'color'   =>  [
          [
            'color' => '#6B98AD',
            'background' => 'bg-palenka',
          ]
        ]
      ],
      [
        'label'   => 'Kilohana',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#E19480',
            'background' => 'bg-kilohana',
          ]
        ]
      ],
      [
        'label'   => 'Hanana',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#A4A887',
            'background' => 'bg-hanana',
          ]
        ]
      ],
      [
        'label'   => 'Eleu',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#A4A887',
            'background' => 'bg-eleu',
          ]
        ]
      ],
      [
        'label'   => 'Mana',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#A4A887',
            'background' => 'bg-mana',
          ]
        ]
      ]
    ],

    'Olina Backgrounds' => [
      [
        'label'   => 'White',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#FFFFFF',
            'background' => 'bg-white',
            'fill' => 'fill-white',
          ]
        ]
      ],
      [
        'label'   => 'Light',
        'default' => true,
        'color'   =>  [
          [
            'color' => '#F0EFE1',
            'background' => 'bg-salt',
            'fill' => 'fill-salt',
          ]
        ]
      ],
    ],

    'Olina Text' => [
      [
        'label'   => 'White',
        'default' => true,
        'color'   =>  [
          [
            'color' => '#FFFFFF',
            'text' => 'text-white',
          ]
        ]
      ],
      [
        'label'   => 'Basalt',
        'default' => false,
        'color'   =>  [
          [
            'color' => '#25272A',
            'text' => 'text-basalt',
          ]
        ]
      ],
    ]

  ]
];
