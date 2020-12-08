<?php

namespace api\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class BaseRestController extends ActiveController
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    protected $args;

    public function __construct(
        $id,
        $module,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->args = \Yii::$app->request->get();
    }

    public function beforeAction($action)
    {
        $header = Yii::$app->request->headers->get('X-Secret');
        $secret = Yii::$app->params['API_SECRET'];
        if ($header !== $secret) throw  new ForbiddenHttpException('Forbidden.');
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formatParam' => '_format',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'xml' => Response::FORMAT_XML
            ],
        ];
        return $behaviors;
    }
}