<?php

return [
  'default' => [
    'handle' => 'home',
    'title' => 'Home Page',
    'content' => '<p>This is a basic.</p>',   
    'image' => '@picsum:1031',
    'buttons' => [
      [
        'text' => 'styleguide',
        'url' => '/styleguide/'
      ]
    ]
  ],
  'search' => [
    'handle' => 'search',
    'title' => 'Search',
    'content' => '',
  ],
  'styleguide' => [
    'handle' => 'styleguide',
    'title' => 'Styleguide Page',
    'content' => '<p class="text-lg mt-sm">This is a simple development page, intended to build out a basic style guide featuring the basic styles.</p><p class="text-lg leading-lg mt-sm">To view the component building blocks of the site, please refer to the <a href="/styleguide/components/">components</a> page.</p>',
    'image' => '@picsum:20',
  ],
  'styleguide/components' => [
    'handle' => 'components',
    'title' => '*Components* Page',
    'content' => '<p class="text-lg leading-lg mt-sm">This is a simple development page, intended to build out and contain the individualized components that will be used to build out the website.</p><p class="text-lg leading-lg mt-sm">To view basic styles, please refer to the <a href="/styleguide/">styleguide</a> page.</p>',
    'image' => '@picsum:180',
  ]
];