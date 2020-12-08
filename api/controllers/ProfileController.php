<?php

namespace api\controllers;

use api\core\entities\User\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

/**
 * Class ProfileController
 * @package api\controllers
 */
class ProfileController extends Controller
{
    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
              HttpBasicAuth::class,
              HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@']
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return User
     */
    public function actionIndex()
    {
        return $this->findModel();
    }

    public function verbs()
    {
        return [
            'index' => ['get']
        ];
    }

    /**
     * @return User
     */
    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}
