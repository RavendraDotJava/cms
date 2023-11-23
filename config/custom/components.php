<?php

/**
 * components.php
 *
 * This configuration file contains the class listings for components.
 */

return [

  // Headers
  'headerWrap' => [

    'DEFAULT' => [
      'width' => 'max-w-p1280 mx-auto',
      'padding' => 'py-p128'
    ],

    'home' => [
      'padding' => 'py-p192',
    ],

    'feed' => [
      'padding' => 'py-p64',
    ],

    'blog' => [
      'padding' => 'mq768:pt-p50 pb-p50'
    ],

    'recipe' => [
      'padding' => 'mq768:pt-p50 pb-p100'
    ],

    'profile' => [
      'padding' => 'py-p50',
    ]
  ],

  // Modules Width
  'moduleWidth' => [

    'DEFAULT' => [
      'width' => 'max-w-p1280',
      'margin' => 'mx-auto'
    ],

    'header' => [
      'width' => 'max-w-p1280',
    ],

    'clients' => [
      'width' => 'max-w-p1024',
    ],

    'faqs' => [
      'width' => 'max-w-p1024',
    ],

    'contentWell' => [
      'width' => 'max-w-p960',
    ],

    'large' => [
      'width' => 'max-w-p1440',
    ]
  ],

  // Modules Padding
  'modulePadding' => [

    'DEFAULT' => [
      'padding' => 'px-p20 mq480:px-p24 mq768:px-p48 mq1024:px-p96',
      'overflow' => '',
      'z-index' => 'relative z-20',
     ],

    'header' => [
      'padding' => 'px-p20 mq480:px-p24 mq768:px-p48',
    ],

    'postHeader' => [
      'padding' => 'px-p20 mq480:px-p24 mq768:px-p48 mq1024:px-p96',
      'z-index' => 'relative',
    ],

    'deepDive' => [
      'overflow' => 'overflow-x-clip',
    ],

    'emphasizedContent' => [
      'overflow' => 'overflow-x-clip',
      'z-index' => 'relative z-10',
    ],

    'callToAction' => [
      'z-index' => 'relative z-20',
    ],

    'feed' => [
      'padding' => 'px-p20 mq480:pl-p128 mq480:pr-p24 mq768:pr-p48 mq1024:pr-p96 mq1280:pl-p96',
    ],

    'customerProfile' => [
      'padding' => 'px-p20 mq480:px-p24 mq768:px-p48 mq1024:px-p96',
    ],

    'checkout' => [
      'padding' => 'px-p20 mq480:px-p24 mq768:px-p48 mq1024:px-p96',
    ],
  ],

  // Buttons
  'button' => [

    'DEFAULT' => [
      'layout' => 'group appearance-none inline-block rounded-full',
      'padding' => 'px-p32 py-p12',
      'color' => 'bg-sand text-basalt',
      'border' => 'border border-transparent',
      'text' => 'text-center mq480:text-lg font-medium',
      'disabled' => 'disabled:opacity-40 disabled:cursor-not-allowed',
      'interact' => 'hover:bg-terracotta hover:text-basalt focus:bg-terracotta focus:text-basalt disabled:hover:bg-basalt disabled:hover:text-white',
      'transition' => 'transition-colors duration-300 ease-in-out',
      'whitespace' => 'whitespace-nowrap',
    ],

    'small' => [
      'text' => 'text-btn mq480:text-sm font-medium',
      'color' => 'bg-salt text-basalt',
      'padding' => 'px-p20 mq480:px-p32 py-p8',
    ],

    'small-terracotta' => [
      'text' => 'text-sm font-medium',
      'color' => 'bg-terracotta text-white',
      'interact' => 'hover:bg-sand hover:text-basalt focus:bg-salt focus:text-basalt',
      'padding' => 'px-p32 py-p8',
    ],

    'secondary' => [
      'color' => 'bg-salt text-basalt',
      'interact' => 'hover:bg-basalt hover:text-white focus:bg-basalt focus:text-white disabled:hover:bg-transparent disabled:hover:text-basalt'
    ],

    'terracotta' => [
      'color' => 'bg-terracotta text-white',
      'interact' => 'hover:bg-sand hover:text-basalt focus:bg-salt focus:text-basalt'
    ],

    'white' => [
      'color' => 'bg-white text-basalt',
      'interact' => 'hover:bg-terracotta hover:text-white focus:bg-terracotta focus:text-white'
    ],

    'arrow' => [
      'layout' => 'group appearance-none inline-block',
      'padding' => '',
      'color' => 'text-basalt',
      'border' => '',
      'text' => 'text-center font-normal text-lg',
      'disabled' => 'disabled:opacity-40 disabled:cursor-not-allowed',
      'interact' => 'hover:underline focus:underline hover:text-basalt focus:text-basalt focus:outline-none',
      'transition' => 'transition-all duration-300 ease-in-out',
      'whitespace' => 'whitespace-nowrap',
      'height' => '',
    ],

    'card' => [
      'layout' => 'appearance-none inline-block',
      'rounded' => '',
      'padding' => '',
      'color' => 'text-type',
      'border' => '',
      'text' => 'text-center text-btn uppercase tracking-wide font-bold',
      'disabled' => 'disabled:opacity-40 disabled:cursor-not-allowed',
      'interact' => 'group-hover:text-white group-focus:text-white',
      'transition' => 'transition-all duration-300 ease-in-out',
      'whitespace' => 'whitespace-nowrap',
      'height' => '',
    ],

    'search' => [
      'layout' => 'overflow-hidden whitespace-nowrap overflow-ellipsis w-full',
      'rounded' => '',
      'padding' => '',
      'color' => 'text-wf-darkest underline',
      'border' => '',
      'text' => '',
      'disabled' => '',
      'interact' => 'hover:underline focus:underline',
      'transition' => '',
      'whitespace' => '',
      'height' => '',
    ],

    'large' => [
      'layout' => 'rounded-p10 basis-1/2 relative after:absolute after:bottom-p20 after:left-1/2 after:-translate-x-1/2 after:w-p50 after:h-p3 after:bg-sand',
      'padding' => 'p-p32',
      'color' => 'bg-white text-basalt',
      'border' => '',
      'text' => 'uppercase text-center font-medium',
      'disabled' => '',
      'interact' => 'hover:bg-basalt hover:text-salt hover:shadow-btn-lg',
      'transition' => 'transition-all duration-100',
      'whitespace' => '',
      'height' => '',
    ],

    // Used as an active state
    'largeDark' => [
      'layout' => 'rounded-p10 basis-1/2 relative after:absolute after:bottom-p20 after:left-1/2 after:-translate-x-1/2 after:w-p50 after:h-p3 after:bg-sand',
      'padding' => 'p-p32',
      'color' => 'bg-basalt text-salt',
      'border' => '',
      'text' => 'uppercase text-center font-medium',
      'disabled' => '',
      'interact' => '',
      'transition' => 'transition-all duration-100',
      'whitespace' => '',
      'height' => '',
    ],


    'largeTerracotta' => [
      'layout' => 'rounded-p10 relative',
      'padding' => 'p-p32',
      'color' => 'bg-terracotta text-basalt font-medium',
      'border' => '',
      'text' => 'uppercase text-center',
      'disabled' => '',
      'interact' => 'hover:bg-sand hover:text-basalt hover:shadow-btn-lg focus:bg-sand focus:text-basalt',
      'transition' => 'transition-all duration-500',
      'whitespace' => '',
      'height' => '',
    ],



  ],

  // Button Icon
  'icon' => [

    'DEFAULT' => [
      'size' => 'w-p32 h-p32',
      'stroke' => 'stroke-none',
      'fill' => 'fill-brand-a11y',
      'transition' => '',
    ],

    'left' => [
      'size' => 'inline relative -top-p1 right-p4 w-p20 h-p20 mr-p4',
      'transition' => '',
    ],

    'image' => [
      'fill' => 'fill-white'
    ],

    'video' => [
      'size' => 'w-p64 h-p64',
      'fill' => 'fill-white'
    ],

    'pagination' => [
      'size' => 'w-p16 w-p16',
    ],

    'secondary-left' => [
      'size' => 'inline relative -top-p1 right-p4 w-p20 h-p20 mr-p4',
      'transition' => 'group-hover:right-p8 group-focus:right-p8 transition-all duration-100 ease-in-out',
    ],

    'buttonPrimary' => [
      'size' => 'w-p24 h-p24 -my-p4',
      'fill' => 'fill-basalt',
      'transition' => 'relative -top-p1 transition-position duration-300 ease-in-out',
    ],

    'buttonSecondary' => [
      'size' => 'w-p16 h-p16 -my-p4',
      'fill' => 'fill-black group-hover:fill-white group-focus:fill-white',
      'transition' => 'relative -top-p1 transition-position duration-300 ease-in-out',
    ],

    'buttonArrow' => [
      'size' => 'w-p20 h-p20',
      'fill' => 'fill-terracotta',
      'transition' => 'relative -top-p1 transition-position duration-300 ease-in-out',
    ],

    'buttonCard' => [
      'size' => 'w-p16 h-p16',
      'fill' => 'fill-brand group-hover:fill-white group-focus:hover',
      'transition' => 'relative -top-p1 transition-position duration-300 ease-in-out',
    ],

  ],

  // Checkbox
  'checkbox' => [

    'DEFAULT' => [
      'appearance' => 'appearance-none cursor-pointer',
      'background' => '',
      'display' => 'peer relative inline-block',
      'size' => 'w-p24 h-p24',
      'rounded' => 'rounded-input',
      'border' => 'border-2 border-terracotta',
      'position' => 'top-p4 inline-block mr-p16',
      'after' => 'after:block after:border-b-2 after:border-l-2 after:border-white after:block after:h-[6px] after:w-[12px] after:-rotate-45 after:absolute after:top-1/2 after:left-1/2 after:-translate-x-1/2 after:-translate-y-1/2 after:invisible after:opacity-0',
      'interact' => 'after:transition-visible after:duration-300 after:ease-in-out',
      'checked' => 'checked:bg-terracotta checked:after:visible checked:after:opacity-100',
    ],

    'dark' => [
      'border' => 'border-2 border-white',
      'background' => 'bg-white',
      'checked' => 'checked:bg-basalt checked:border-basalt checked:after:visible checked:after:opacity-100',
    ],

    'radio' => [
      'rounded' => 'rounded-full',
      'after' => 'after:block after:bg-white after:block after:rounded-full after:h-p8 after:w-p8 after:-rotate-45 after:absolute after:top-1/2 after:left-1/2 after:-translate-x-1/2 after:-translate-y-1/2 after:invisible after:opacity-0',
    ]

  ],

  // Intro
  'intro' => [

    'DEFAULT' => [
      'size' => 'max-w-p768',
      'align' => 'text-center',
      'margin' => 'mb-p64 mx-auto'
    ],

    'benefits' => [
      'align' => 'text-left',
      'margin' => 'mb-p64'
    ],

    'relatedProducts' => [
      'align' => 'text-left',
    ],

    'productReviews' => [
      'align' => 'text-left',
      'margin' => 'mb-p64'
    ],

    'deepDive' => [
      'align' => 'text-left',
      'margin' => 'mb-p32 mq912:mb-p64 mx-auto'
    ],

    'deepDiveCenter' => [
      'align' => 'text-center',
      'margin' => 'mb-p32 mx-auto'
    ],

    'form' => [
      'align' => 'text-left',
      'margin' => 'mb-p40 mq768:mb-none'
    ],
  ],

  'introHeading' => [

    'DEFAULT' => [
      // 'size' => 'text-h2',
    ],

  ],

  'introContent' => [

    'DEFAULT' => [
      'default' => 'c-content',
      'size' => 'mq640:text-lg',
      'margin' => 'mt-p32'
    ],

  ],

  // Skip Link
  'skip' => [

    'DEFAULT' => [
      'base' => 'fixed z-100 -top-p100 left-1/2 bg-brand text-white rounded-b-card',
      'text' => 'text-sm uppercase tracking-widest',
      'padding' => 'px-p16 py-p8',
      'position' => 'transform -translate-x-1/2 -translate-y-full',
      'interact' => 'focus:translate-y-none transition-transform duration-300 ease-in-out top-0'
    ],
  ],

  'categoryTag' => [
    'DEFAULT' => [
      'base' => 'rounded-full',
      'padding' => 'py-p4 px-p20',
      'background' => 'bg-salt',
      'text' => 'text-btn font-normal',
      'interact' => '',
    ],

    'light' => [
      'background' => 'bg-white',
      'interact' => 'transition-colors hover:bg-terracotta focus:bg-terracotta',
    ],

    'dark' => [
      'background' => 'bg-basalt',
      'padding' => 'py-p2 px-p20',
      'text' => 'text-white text-btn font-normal',
      'interact' => '',
    ]
  ],

  'label' => [
    'DEFAULT' => [
      'base' => 'text-basalt mq480:text-lg font-normal block mb-p10'
    ]
  ],

  'roundedCard' => [

    'DEFAULT' => [
      'display' => 'block',
      'radius' => 'rounded-md',
      'padding' => 'px-p32 py-p24',
      'background' => 'bg-white',
      'shadow' => '',
      'margin' => '',
    ],

    'customerProfile' => [
      'radius' => 'rounded-xl',
    ],

    'checkoutAddresses' => [
      'radius' => 'rounded-2xl',
      'padding' => 'px-p32 py-p24',
      'background' => 'bg-salt',
    ],

    'form' => [
      'radius' => 'rounded-2xl',
      'shadow' => 'shadow-card-lg',
      'padding' => 'py-p40 px-p32 mq480:px-p40 mq768:p-p80',
    ],

    'checkoutPage' => [
      'radius' => 'mq1280:rounded-t-2xl',
      'shadow' => 'shadow-card-lg',
      'padding' => 'px-p20 py-p40 mq480:p-p24 mq480:p-p40 mq1280:p-p100 mq768:pb-p230',
      'margin' => '-mx-p20 mq480:-mx-p24 mq768:-mx-p48 mq1024:-mx-p96 mq1280:mx-none',
    ],

    'productCta' => [
      'shadow' => 'shadow-card-lg',
      'radius' => 'rounded-p20',
      'padding' => 'px-p32 pt-p64 pb-p128 mq768:pb-p64 mq480:px-p32 mq1024:px-p128'
    ],
  ],

  'contentCard' => [
    'DEFAULT' => [
      'display' => 'block mq640:flex items-end',
      'position' => 'relative',
      'padding' => 'p-p50',
      'rounded' => 'rounded-2xl',
      'text' => 'text-white',
      'flex' => 'shrink-0 basis-1/2',
      'height' => 'mq640:h-p450',
      'interaction' => 'group transition-all hover:shadow-card-lg focus:shadow-card-lg'
    ]
  ],

  'formItem' => [

    'DEFAULT' => [
      'margin' => 'mb-p16 mq768:mb-p20',
      'position' => 'relative',
    ]
  ],

  'input' => [

    'DEFAULT' => [
      'base' => 'appearance-none',
      'size' => 'w-full',
      'radius' => 'rounded-full',
      'padding' => 'py-p16 px-p20 mq480:px-p30',
      'text' => 'text-bd mq480:text-lg font-normal',
      'background' => 'bg-white',
      'border' => 'border border-terracotta',
      'position' => 'relative',
      'placeholder' => 'placeholder:text-control',
    ],

    'inputWithSubmitContainer' => [
      'padding' => 'mq768:py-p8 mq768:pl-p20 mq768:pl-p30 mq768:pr-p8',
      'background' => 'mq768:bg-salt',
      'border' => 'border-none',
    ],

    'inputWithSubmit' => [
      'base' => 'appearance-none mq768:focus:outline-none',
      'radius' => 'rounded-full',
      'padding' => 'py-p16 px-p20 mq480:px-p30 mq768:p-none',
      'text' => 'text-bd mq480:text-lg font-normal',
      'background' => 'bg-salt mq768:bg-transparent',
      'border' => 'border-none',
      'position' => 'relative',
      'placeholder' => 'placeholder:text-basalt',
    ],

    'inputWithSubmitContainerLight' => [
      'padding' => 'mq768:py-p8 mq768:pl-p20 mq768:pl-p30 mq768:pr-p8',
      'background' => 'mq768:bg-white',
      'border' => 'border-none',
    ],

    'inputWithSubmitLight' => [
      'base' => 'appearance-none mq768:focus:outline-none',
      'radius' => 'rounded-full',
      'padding' => 'py-p16 px-p20 mq480:px-p30 mq768:p-none',
      'text' => 'text-bd mq480:text-lg font-normal',
      'background' => 'bg-white mq768:bg-transparent',
      'border' => 'border-none',
      'position' => 'relative',
      'placeholder' => 'placeholder:text-basalt',
    ],

    'textarea' => [
      'radius' => 'rounded-3xl'
    ],

    'medium' => [
      'radius' => 'rounded-full',
      'padding' => 'px-p16 py-p10',
      'text' => 'text-lg font-normal',
      'border' => 'border border-control',
    ],

    'small' => [
      'base' => 'appearance-none block',
      'size' => 'w-full',
      'radius' => 'rounded',
      'padding' => 'px-p16 py-p8',
      'text' => 'text-bd',
      'border' => 'border border-rule',
    ],

    'number' => [
      'size' => 'w-p100',
    ],

    'numberLg' => [
      'size' => 'w-p128',
    ],

    'quantity' => [
      'base' => 'appearance-none inline',
      'radius' => '',
      'padding' => '',
      'text' => 'text-lg font-normal text-center',
      'background' => 'bg-transparent',
      'border' => '',
      'position' => '',
      'placheolder' => '',
    ],

    'select' => [
      'base' => 'appearance-none cursor-pointer',
    ],

    'selectMulti' => [
      'base' => 'appearance-none cursor-pointer',
      'radius' => '',
    ]
  ],

  'flashNotice' => [

    'DEFAULT' => [
      'base' => 'mx-auto max-w-p448',
      'background' => 'bg-white',
      'shadow' => 'shadow-notice',
      'text' => 'text-basalt',
      'margin' => 'mb-p16 last:mb-none',
      'radius' => 'rounded-b',
      'padding' => 'p-p32',
    ]
  ],

  'mediaLocation' => [
    'DEFAULT' => [
      'position' => 'absolute right-0 bottom-p128 z-20',
      'background' => 'bg-basalt bg-opacity-30',
      'radius' => 'rounded-l-full',
      'padding' => 'px-p20 py-p8',
      'text' => 'text-white',
      'display' => 'flex items-center',
    ]
  ],

  'summaryItem' => [
    'DEFAULT' => [
      'display' => 'block',
      'padding' => 'py-p50',
      'border' => 'border-t border-terracotta'
    ],
    'noBorder' => [
      'border' => 'border-t border-transparent'
    ]
  ],

  'tabItem' => [
    'DEFAULT' => [
      'display' => 'flex items-center justify-center',
      'padding' => 'p-p32',
      'text' => 'text-lg',
      'background' => 'bg-white',
      'radius' => 'rounded-t-2xl',
      'shadow' => 'shadow-card-lg'
    ]
  ],


  'basicLink' => [
    'DEFAULT' => [
      'text' => 'text-lg underline hover:no-underline font-normal',
      'margin' => ' mt-p10 mq640:mt-none mq640:ml-p12 mq640:mt-p4',
      'display' => 'inline-block',
    ]
  ],

  'parallaxPosition' => [
    'DEFAULT' => [
      'position' => 'right-0',
    ],
    'offsetLeft' => [
      'position' => '-left-p100 mq1024:-left-p200',
    ],
    'middle' => [
      'position' => '-left-p100 mq768:left-0 mq1024:left-p450',
    ],
    'right' => [
      'position' => '-right-p100 mq768:right-0',
    ],
    'offsetRight' => [
      'position' => '-right-p100 mq1024:-right-p200',
    ],
  ],

  'parallaxDistance' => [
    'DEFAULT' => [
      'blur' => 'blur-0',
      'shadow' => 'drop-shadow-none',
    ],
    'foreground' => [
      'blur' => 'blur-4',
      'shadow' => 'drop-shadow-far',
    ],
    'middle' => [
      'blur' => 'blur-1-1/2',
      'shadow' => 'drop-shadow-mid',
    ],
    'background' => [
      'blur' => 'blur-0',
      'shadow' => 'drop-shadow-close',
    ],
  ],

  'sliderButton' => [
    'DEFAULT' => [
      'base' => 'rounded-full bg-white p-p12 group transition-all absolute z-20',
      'position' => 'bottom-0 mq480:bottom-auto mq480:top-1/2 mq480:-translate-y-1/2',
      'opacity' => 'mq1024:opacity-0 mq1024:group-hover:opacity-50 mq1024:group-hover:hover:opacity-100',
      'focus' => 'focus:outline-terracotta',
    ],
  ]
];
