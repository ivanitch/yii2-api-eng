<?php

namespace backend\controllers;

use backend\forms\WordSearch;
use core\forms\manage\Word\ImageForm;
use core\forms\manage\Word\SoundForm;
use core\forms\manage\Word\WordForm;
use core\services\manage\WordManageService;
use core\storage\Word\ImageStorage;
use core\storage\Word\SoundStorage;
use Yii;
use core\entities\Word\Word;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * WordController implements the CRUD actions for Word model.
 */
class WordController extends Controller
{
    private $service;
    private $imgStorage;
    private $soundStorage;

    public function __construct(
        $id,
        $module,
        WordManageService $service,
        ImageStorage $imgStorage,
        SoundStorage $soundStorage,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->imgStorage = $imgStorage;
        $this->soundStorage = $soundStorage;
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
     * Lists all Word models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Word model.
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
     * Creates a new Word model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new WordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->uploadImage($form);
                $this->uploadSound($form);
                $word = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Word <strong>' . $word->name . '</strong> added!');
                return $this->redirect(['view', 'id' => $word->id]);
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
     * Updates an existing Word model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $word = $this->findModel($id);
        $form = new WordForm($word);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->uploadImage($form, $word->image);
                $this->uploadSound($form, $word->sound);
                $this->service->edit($word->id, $form);
                Yii::$app->session->setFlash('success', 'Word <strong>' . $word->name . '</strong> updated!');
                return $this->redirect(['view', 'id' => $word->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'word' => $word,
        ]);
    }

    /**
     * Deletes an existing Word model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $word = $this->findModel($id);
            $this->service->remove($word->id);
            Yii::$app->session->setFlash('success', 'Word <strong>' . $word->name . '</strong> removed!');
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
                $this->service->save($model);
                Yii::$app->session->setFlash('success', 'Image removed!');
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
                $this->service->save($model);
                Yii::$app->session->setFlash('success', 'Image changed!');
                return $this->redirect(['view', 'id' => $model->id]);

            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('image', [
            'model' => $form,
            'word' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDeleteSound($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            try{
                $this->deleteSound($model);
                $this->service->save($model);
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
    public function actionChangeSound($id)
    {
        $model = $this->findModel($id);
        $form = new SoundForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->changeSound($model, $form);
                $this->service->save($model);
                Yii::$app->session->setFlash('success', 'Sound changed!');
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('sound', [
            'model' => $form,
            'word' => $model,
        ]);
    }

    /**
     * @param WordForm $form
     * @param null $current
     */
    private function uploadImage(WordForm $form, $current = null): void
    {
        $image = UploadedFile::getInstance($form->image, 'image');
        if (is_null($image)) $form->image = '';
        else $form->image = $this->imgStorage->save($image, $current);
    }

    /**
     * @param WordForm $form
     * @param null $current
     */
    private function uploadSound(WordForm $form, $current = null): void
    {
        $sound = UploadedFile::getInstance($form->sound, 'file');
        if (is_null($sound)) $form->sound = '';
        else $form->sound = $this->soundStorage->save($sound, $current);
    }

    /**
     * @param Word $model
     * @param ImageForm $form
     */
    private function changeImage(Word $model, ImageForm $form): void
    {
        $image = UploadedFile::getInstance($form, 'image');
        if (!is_null($image)) {
            $model->image = $this->imgStorage->save($image, $model->image);
        }
    }

    /**
     * @param Word $model
     * @param SoundForm $form
     */
    private function changeSound(Word $model, SoundForm $form): void
    {
        $sound = UploadedFile::getInstance($form, 'file');
        if (!is_null($sound)) {
            $model->sound = $this->soundStorage->save($sound, $model->sound);
        }
    }

    public function deleteImage(Word $word)
    {
        $this->imgStorage::deleteImage($word);
    }

    public function deleteSound(Word $word)
    {
        $this->soundStorage::deleteSound($word);
    }

    /**
     * Finds the Word model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Word the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Word::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
