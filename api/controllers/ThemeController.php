<?php

namespace api\controllers;

use api\core\entities\Theme;
use api\models\ThemeSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ThemeController extends BaseRestController
{
    /* @var $modelClass Theme */
    public $modelClass = Theme::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider(): ActiveDataProvider
    {
        $searchModel = new ThemeSearch();
        return $searchModel->search($this->args);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    protected function findModel($id): Theme
    {
        if (($model = Theme::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
