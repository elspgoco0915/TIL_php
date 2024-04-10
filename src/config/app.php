<?php
/**
 * @var array 
 * NOTE: 呼び方
 *  Configure::read('app.sample.env');
 */
return [
    'sample' => [
        'env' => $_ENV['SAMPLE_ENV'],
    ],
    'mysql' => [
        'host'  => 'til_php-db',
        'db'    => 'til_php',
        'user'  => 'til_php',
        'pw'    => 'til_php-pw'
    ],
];