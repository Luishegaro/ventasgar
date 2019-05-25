<?php

namespace app\controllers;
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\MaterialForm;
use app\models\DetalleForm;

class AdminMaterialController extends Controller
{
    public function behaviors()
    {
         return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','create','update','delete'],
              'rules' => [
                  [
                      'actions' => ['index','create','update','delete'],
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
          ],
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'logout' => ['post'],
                  ],
              ],
          ];
    }

    public function actionIndex(){
        $lista = MaterialForm::getMateriales();
        return $this->render('index',[
            'lista' => $lista,
            ]);
    }
    public function actionCreate(){
        $model=new MaterialForm();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            Yii::$app->session->setFlash('success','Material registrado exitósamente.');
            $this->redirect(['index']);
        }
        $model->_usuario=Yii::$app->user->id;
        $model->_registrado=date('Y-m-d H:i:s');
        return $this->render('create', [
            'material' => $model,
        ]);
    }
    public function actionUpdate($id_material){
        $model=MaterialForm::getById($id_material);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ".$id_material);
        }
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('success','Material modificado exitósamente.');
            $this->redirect(['index']);
        }
        return $this->render('update', [
            'material' => $model,
        ]);

    }
    public function actionDelete($id_material){
        $model=MaterialForm::getById($id_material);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ".$id_material);
        }
        
        $ventas=DetalleForm::countById($id_material);
        if ($ventas>0) {
          Yii::$app->session->setFlash('error','No se puede eliminar, Tiene operaciones regitradas');
          return $this->redirect(['index']);
        }
        if ($model->delete()) {
            Yii::$app->session->setFlash('success','Material eliminado exitósamente.');
            $this->redirect(['index']);
        }
    }
}

