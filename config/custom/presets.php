<?php
/**
 * Presets
 *
 * All the configration for the preset options.
 */

return [
  'alignment' => [
    'name' => 'Alignment',
    'values' => [
        'left' => 'Left',
        'center' => 'Center',
        'right' => 'Right',
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
  ],
  'stickyHeader' => [
    'name' => 'Sticky Header',
    'values' => [
        'off' => 'Off',
        'persistent' => 'Persistent',
        'down' => 'Scroll Down',
    ]
  ],
  'logosize' => [
    'name' => 'Logo Size',
    'values' => [
        'client' => 'Normal',
        'clientWide' => 'Wide',
        'clientSquare' => 'Square',
    ]
  ],
  'videos' => [
    'name' => 'Video Types',
    'values' => [
        'youtube' => 'YouTube',
        'vimeo' => 'Vimeo',
    ]
  ],
  'headerStyle' => [
    'name' => 'Header Style',
    'values' => [
        'white' => 'White',
        'transparent' => 'Transparent',
    ]
  ],
  'pageHeaderStyle' => [
    'name' => 'Page Header Style',
    'values' => [
        'seamless' => 'Seamless Background',
        'bgBorder' => 'Background with border',
    ]
  ],
  'pageHeaderPadding' => [
    'name' => 'Page Header Padding',
    'values' => [
        'large' => 'Large',
        'small' => 'Small',
    ]
  ],
  'buttonStyle' => [
    'name' => 'Button Style',
    'values' => [
        'primary' => 'Primary',
        'secondary' => 'Secondary',
        'terracotta' => 'Terracotta',
        'white' => 'White',
        'large' => 'Large',
    ]
  ],
  'buttonStyleLimited' => [
    'name' => 'Button Style Limited',
    'values' => [
        'primary' => 'Primary',
        'secondary' => 'Secondary',
        'terracotta' => 'Terracotta',
        'white' => 'White',
    ]
  ],
  'measurements' => [
    'name' => 'Measurement Unit',
    'values' => [
        'none' => 'none',
        'cup' => 'cup',
        'tsp' => 'tsp',
        'tbsp' => 'tbsp',
        'l' => 'L',
        'ml' => 'ml',
        'qrt' => 'qrt',
        'oz' => 'oz',
      ]
    ],
    'ctaDecorations' => [
      'name' => 'CTA Decorations',
      'values' => [
        'none' => 'None',
        'diagonalBrushTL' => 'Diagonal Brush Top Left',
        'diagonalBrushBL' => 'Diagonal Brush Bottom Left',
        'horizontalBrush' => 'Brush Right',
        'verticalBrush' => 'Brush Bottom',
      ]
    ],
    'accountActions' => [
      'name' => 'Account Actions',
      'values' => [
        'none' => 'None',
        'deactivateAccount' => 'Deactivate Account',
        'deleteAccount' => 'Delete Account',
        'resetPassword' => 'Reset Password',
      ]
    ],
    'filterEntryType' => [
      'name' => 'Filter Entry Types',
      'values' => [
        'all' => 'All',
        'blog' => 'Blog Posts',
        'recipe' => 'Recipes',
      ]
    ]
];
