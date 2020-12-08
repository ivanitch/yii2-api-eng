<?php

namespace api\controllers;

use api\core\forms\LoginForm;
use Yii;
use yii\rest\Controller;

class SiteController extends Controller
{

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($token = $model->auth()) return $token;
        return $model;
    }

    /**
     * @return array|\string[][]
     */
    protected function verbs(): array
    {
        return [
            'login' => ['post'],
        ];
    }
}