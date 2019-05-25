<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;
use yii\filters\VerbFilter;

class RbacController extends Controller
{
  public function behaviors()
  {
      return [
      'access' => [
          'class' => AccessControl::className(),
          'only' => ['index','create-user','update-user','delete-user'],
          'rules' => [
              [
                  'actions' => ['index','create-user','update-user','delete-user'],
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

    $criterio = '%';
    if(Yii::$app->request->get('c')){
      $criterio = Yii::$app->request->get('c');
    }

    $usuarios = User::find($criterio);

    return $this->render('index', [
            'usuarios' => $usuarios,
        ]);
  }

  public function actionCreateUser(){
    
      $model = new User();

      if($model->load(Yii::$app->request->post()) && $model->create()){
        return $this->redirect(['index']);
      }

      return $this->render('usuario-form',[
          'model' => $model,
          'accion' => 'Nuevo',
        ]);
   
  }

  
  public function actionUpdateUser($id){
    
      $model = User::findIdentity($id);
      if(!isset($model)){
        throw new \yii\web\ForbiddenHttpException("No existe el usuario: ".$id);
      }

      if($model->load(Yii::$app->request->post()) && $model->update()){
        return $this->redirect(['index']);
      }

      return $this->render('usuario-form',[
        'model' => $model,
        'accion' => 'Modificar',
      ]);
   
  }

  public function actionDeleteUser($id){ 
      $model = User::findIdentity($id);
      if(!isset($model)){
        throw new \yii\web\ForbiddenHttpException("No existe el usuario: ".$id);
      }

      //primero elimina sus asignaciones
      Yii::$app->authManager->revokeAll($model->id);

      //elimina al usuario de la bd
      if($model->delete()){
        return $this->redirect(['index']);
      }
  } 
}