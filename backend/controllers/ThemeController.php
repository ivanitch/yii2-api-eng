<?php

namespace backend\controllers;

use backend\forms\ThemeSearch;
use core\forms\manage\Theme\ImageForm;
use core\forms\manage\Theme\ThemeForm;
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
                $this->image($form);
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
                $this->image($form, $theme->image);
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
                $model->deleteImage();
                $model->image = '';
                if($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Image removed!');
                }
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
                if (!is_null($image = UploadedFile::getInstance($form, 'image'))) {
                    $model->image = $this->storage->save($image, $model->image);
                }
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Image changed!');
                }
                return $this->render('view', [
                    'model' => $model,
                ]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('image', [
            'model' => $form,
            'theme' => $model,
        ]);
    }

    private function image(ThemeForm $form, $currentImage = null)
    {
        if (!is_null($image = UploadedFile::getInstance($form->image, 'image'))) {
            if ($currentImage) $form->image = $this->storage->save($image, $currentImage);
            else $form->image = $this->storage->save($image);
        } else {
            $form->image = '';
        }
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
