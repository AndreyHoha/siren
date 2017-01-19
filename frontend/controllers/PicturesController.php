<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Pictures;
use frontend\models\PicturesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use yii\imagine\Image;
/**
 * PicturesController implements the CRUD actions for Pictures model.
 */
class PicturesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pictures models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PicturesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pictures model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pictures model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $model = new Pictures();

      $model->user_id = Yii::$app->user->id;

      if ($model->user_id > 0) {
        $model->file = UploadedFile::getInstance($model, 'file');
        if ($model->file) { // && $model->validate()
          $model->picture = '/var/www/html/uploads/' . $model->file->baseName . '.' . $model->file->extension;
          $model->file->saveAs($model->picture);
        }
      }

      //if ($model->load(Yii::$app->request->post()) && $model->save()) {
      if ($model->save()) {
          return $this->redirect(['update', 'id' => $model->id]);
      } else {
          return $this->render('create', [
              'model' => $model,
          ]);
      }
    }

    /**
     * Updates an existing Pictures model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      $model = $this->findModel($id);

      if (Yii::$app->request->post()) {
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //return $this->redirect(['view', 'id' => $model->id]);
        Image::frame($model->picture, 5, '666', 0)
          ->rotate(-8)
          ->save($model->picture, ['jpeg_quality' => 80]);
      }
      return $this->render('update', [
          'model' => $model,
      ]);
    }

    public function actionWatermark($id)
    {
      $model = $this->findModel($id);
      //if (Yii::$app->request->post()) {
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //return $this->redirect(['view', 'id' => $model->id]);

      $watermark = Image::frame('/var/www/html/uploads/a.jpg', 5, '666', 0);
      Image::frame($model->picture, 5, '666', 0)
        ->mask($watermark)
        //->watermark($watermark)
        //->text('watermark')
        ->save($model->picture, ['jpeg_quality' => 80]);

      return $this->render('update', [
        'model' => $model,
      ]);
    }

    /**
     * Deletes an existing Pictures model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pictures model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pictures the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pictures::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
