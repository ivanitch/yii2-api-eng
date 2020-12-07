<?php

namespace backend\controllers;

use backend\forms\CategorySearch;
use core\forms\manage\Category\CategoryForm;
use core\forms\manage\Category\IconForm;
use core\services\manage\CategoryManageService;
use core\storage\Category\IconStorage;
use Yii;
use core\entities\Category\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    private $service;
    private $storage;

    public function __construct(
        $id,
        $module,
        CategoryManageService $service,
        IconStorage $iconStorage,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->storage = $iconStorage;
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new CategoryForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->uploadIcon($form);
                $category = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Category <strong>' . $category->name . '</strong> added!');
                return $this->redirect(['view', 'id' => $category->id]);
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
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $category = $this->findModel($id);
        $form = new CategoryForm($category);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->uploadIcon($form, $category->icon);
                $this->service->edit($category->id, $form);
                Yii::$app->session->setFlash('success', 'Category <strong>' . $category->name . '</strong> updated!');
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'category' => $category,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $this->service->remove($model->id);
            Yii::$app->session->setFlash('success', 'Category <strong>' . $model->name . '</strong> removed!');
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
    public function actionDeleteIcon($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            try{
                $this->deleteIcon($model);
                if($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Icon removed!');
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
    public function actionChangeIcon($id)
    {
        $model = $this->findModel($id);
        $form = new IconForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->changeIcon($model, $form);
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Icon changed!');
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('icon', [
            'model' => $form,
            'category' => $model,
        ]);
    }

    private function uploadIcon(CategoryForm $form, $current = null): void
    {
        $icon = UploadedFile::getInstance($form->icon, 'icon');
        if (is_null($icon)) $form->icon = '';
        else $form->icon = $this->storage->save($icon, $current);
    }

    private function changeIcon(Category $model, IconForm $form): void
    {
        $icon = UploadedFile::getInstance($form, 'icon');
        if (!is_null($icon)) {
            $model->icon = $this->storage->save($icon, $model->icon);
        }
    }

    private function deleteIcon(Category $category)
    {
        $this->storage::deleteIcon($category);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
