<?php

return [
    'fields' => [
        'contentModules' => [
            'groups' => [
            [
                'label' => 'Content',
                'types' => ['emphasizedContent', 'benefits', 'faqs', 'contentWell', 'comparisonChart',],
            ], [
                'label' => 'Actions',
                'types' => ['callToAction', 'form'],
            ], [
              'label' => 'Cards',
              'types' => ['entryCards', 'contentCards', 'productCards',],
            ], [
                'label' => 'Integrations',
                'types' => ['htmlEmbed'],
            ], [
                'label' => 'Product',
                'types' => ['productFeature', 'relatedProducts', 'deepDive',],
            ]
          ]
        ],
    ],
];