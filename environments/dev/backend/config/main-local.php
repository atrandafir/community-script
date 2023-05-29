<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        'generators' => [ // here
            'crud' => [ // generator name
                'class' => 'backend\gii\generators\crud\Generator', // generator class
                'templates' => [ // setting for our templates
                    'community-script' => '@backend/gii/generators/crud/default', // template name => path to template
                ]
            ],
            'model' => [ // generator name
                'class' => 'backend\gii\generators\model\Generator', // generator class
                'templates' => [ // setting for our templates
                    'community-script' => '@backend/gii/generators/model/default',
                ]
            ]
        ]
    ];
}

return $config;
