<?php

namespace backend\controllers;

use backend\forms\ThemeSearch;
use core\forms\manage\Theme\ImageForm;
use core\forms\manage\Theme\ThemeForm;
use core\forms\manage\Theme\WordsForm;
use core\services\manage\ThemeManageService;
use core\storage\Theme\ImageStorage;
use Yii;
use core\entities\Theme\Theme;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * ThemeController implements the CRUD actions for Theme model.
 */
class ThemeController extends Controller
{
    private $service;
    private $storage;

    public function __construct(
        $id,
        $module,
        ThemeManageService $service,
        ImageStorage $storage,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->storage = $storage;
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Theme models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThemeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Theme model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Theme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new ThemeForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->uploadImage($form);
                $theme = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Theme <strong>' . $theme->name . '</strong> added!');
                return $this->redirect(['view', 'id' => $theme->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Theme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $theme = $this->findModel($id);
        $form = new ThemeForm($theme);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->uploadImage($form, $theme->image);
                $this->service->edit($theme->id, $form);
                Yii::$app->session->setFlash('success', 'Theme <strong>' . $theme->name . '</strong> updated!');
                return $this->redirect(['view', 'id' => $theme->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'theme' => $theme,
        ]);
    }

    /**
     * Deletes an existing Theme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $theme = $this->findModel($id);
            $this->service->remove($theme->id);
            Yii::$app->session->setFlash('success', 'Theme <strong>' . $theme->name . '</strong> removed!');
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDeleteImage($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            try{
                $this->deleteImage($model);
                if($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Image removed!');
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionChangeImage($id)
    {
        $model = $this->findModel($id);
        $form = new ImageForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
               $this->changeImage($model, $form);
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Image changed!');
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('image', [
            'model' => $form,
            'theme' => $model,
        ]);
    }

    private function uploadImage(ThemeForm $form, $current = null): void
    {
        $image = UploadedFile::getInstance($form->image, 'image');
        if (is_null($image)) $form->image = '';
        else $form->image = $this->storage->save($image, $current);
    }

    private function changeImage(Theme $model, ImageForm $form): void
    {
        $image = UploadedFile::getInstance($form, 'image');
        if (!is_null($image)) {
            $model->image = $this->storage->save($image, $model->image);
        }
    }

    private function deleteImage(Theme $model)
    {
        $this->storage::deleteImage($model);
    }

    public function actionAddWords($id)
    {
        $theme = $this->findModel($id);
        $form = new WordsForm($theme);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addWords($theme, $form);
                return $this->redirect(['view', 'id' => $theme->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('words', [
            'theme' => $theme,
            'model' => $form
        ]);
    }

    /**
     * Finds the Theme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Theme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Theme::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
