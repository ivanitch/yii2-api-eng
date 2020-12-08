<?php
/** @var array $params */
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        'POST auth' => 'site/login',
        'GET profile' => 'profile/index',

        //=== Category
        'GET categories/page=<page:\d+>' => 'category/index',
        'GET categories' => 'category/index',
        'GET categories/<id:\d+>' => 'category/view',

        //=== Level
        [
            'pluralize' => true,
            'class' => 'yii\rest\UrlRule',
            'controller' => 'level'
        ],

        //=== Theme
        [
            'pluralize' => true,
            'class' => 'yii\rest\UrlRule',
            'controller' => 'theme'
        ],
    ],
];