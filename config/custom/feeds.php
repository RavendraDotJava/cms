<?php
/**
 * Feeds Configuration
 *
 * All of the configurations in here are specifically used to drive
 * the feed component. The idea here is to provide filters via a modifiable
 * configuration, rather than in templates or in the database.
 */

return [
  'all' => [
    'count' => 9,
    'sections' => ['blog', 'recipe'],
    'filters' => 'filters',
  ],
  'blog' => [
    'count' => 9,
    'sections' => ['blog'],
    'filters' => 'filters',
  ],
  'recipe' => [
    'count' => 9,
    'sections' => ['recipe'],
    'filters' => 'filters',
  ],
];
