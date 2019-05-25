<?php

namespace app\controllers;
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ClienteForm;
use app\models\ClienteSearch;
use app\models\PagoForm;
use app\models\Venta;
use app\models\Contador;
use yii\bootstrap\ActiveForm;

class AdminClienteController extends Controller
{
    public function behaviors()
    {
        return [
      'access' => [
          'class' => AccessControl::className(),
          'only' => ['index','create','update','createajax','delete'],
          'rules' => [
              [
                  'actions' => ['index','create','update','createajax','delete'],
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

        $searchModel = new ClienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate(){
        $model=new ClienteForm();
        $model->deuda=0;
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            Yii::$app->session->setFlash('success','Cliente registrado exitósamente.');
            $this->redirect(['index']);
        }
        $model->_estado='A';
        $model->_usuario=Yii::$app->user->id;
        $model->_registrado=date('Y-m-d H:i:s');
        return $this->render('create', [
            'cliente' => $model,
        ]);
    }
    public function actionCreateAjax(){
        $model=new ClienteForm();
        $model->deuda=0;
        $model->_estado='A';
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            Yii::$app->session->setFlash('success','Cliente registrado exitósamente.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model->_usuario=Yii::$app->user->id;
        $model->_registrado=date('Y-m-d H:i:s');
        return $this->renderAjax('create', [
            'cliente' => $model,
        ]);
        
    }
    public function actionUpdateAjax($id_cliente){
      
        $model=ClienteForm::getById($id_cliente);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ".$id_cliente);
        }
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('success','Cliente modificado exitósamente.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update', [
            'cliente' => $model,
        ]);
      
        
    }
    public function actionValidation(){
        $model=new ClienteForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format='json';
            return ActiveForm::validate($model);
        }
    }
    public function actionUpdate($id_cliente){
        $model=ClienteForm::getById($id_cliente);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ".$id_cliente);
        }
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('success','Cliente modificado exitósamente.');
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'cliente' => $model,
        ]);

    }
    public function actionDelete($id_cliente){
        $model=ClienteForm::getById($id_cliente);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ".$id_cliente);
        }
        $ventas=Contador::countById('venta','id_venta','id_cliente',$id_cliente);
        $pagos=Contador::countById('pago','id_pago','id_cliente',$id_cliente);
        if ($ventas>0 || $pagos>0) {
            Yii::$app->session->setFlash('error','No se puede eliminar, Tiene operaciones regitradas');
            return $this->redirect(['index']);
        }
        else{
            $model->delete();
            Yii::$app->session->setFlash('success','Cliente eliminado exitósamente.'.$ventas);
            return $this->redirect(['index']);
        }
        
    }
    

}

