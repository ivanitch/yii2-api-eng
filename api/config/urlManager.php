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
    ],
];