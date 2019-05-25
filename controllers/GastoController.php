<?php

namespace app\controllers;

use Yii;
use app\models\Gasto;
use yii\filters\AccessControl;
use app\models\GastoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * AdelantoController implements the CRUD actions for Adelanto model.
 */
class GastoController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors()
    {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','create','update','view','delete','print'],
              'rules' => [
                  [
                      'actions' => ['index','create','update','view','delete','print'],
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

    /**
     * Lists all Adelanto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GastoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adelanto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      $this->imprimir($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adelanto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gasto();
        if ($model->load(Yii::$app->request->post())&& $model->create()) {
            $id=Gasto::getLastInsertedId();

            return $this->redirect($url = (Yii::$app->user->identity->rol=="VENTAS") ? ['view', 'id' => $id]:['index']);
            
        } else {
            $model->pagado_a=(Yii::$app->request->get('nombre'))?Yii::$app->request->get('nombre'):null;
            $model->tipo='OTROS';
            $model->fecha=date('d-m-Y');
            $model->_usuario=Yii::$app->user->id;
            $model->_registrado=date('Y-m-d H:i:s');
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Adelanto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fecha=date_format(date_create($model->fecha),"d-m-Y");
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect(['view', 'id' => $model->id_gasto]);
        } else {
            $activo=(isset($model->id_activo))?false:true;
            return $this->render('update', [
                'model' => $model,
                'activo'=>$activo,
            ]);
        }
    }

    /**
     * Deletes an existing Adelanto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $model->_estado=($model->_estado=='X')?'A':'X';
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Adelanto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adelanto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gasto::getById($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function imprimir($id) {
        $model=$this->findModel($id);
        $content = $this->renderPartial('view-print',[
            'model'=>$model,
        ]);
    
    // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_UTF8, 
        // A4 paper format
        'format' => Pdf::FORMAT_LETTER, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_FILE, 
        'filename'=>'pdfs/gasto.pdf',
        // your html content input
        'content' => $content, 
        'marginLeft'=>8,
        'marginTop'=>3, 
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '#tbdetalle {
            border-collapse: collapse;
        }

        #tbdetalle th{
            border-bottom:1pt solid black;
        }
        #tbdetalle #tdtot{
            border-bottom:1pt solid black;
        }
        #tbdetalle td:nth-child(1){
            text-align:right;
        }
        #tbdetalle td:nth-child(3){
            text-align:right;
        }
        #tbdetalle td:nth-child(4){
            text-align:right;
        }
        ',
         // set mPDF properties on the fly
        
         // call mPDF methods on the fly
        
    ]);
    
    // return the pdf output as per the destination setting
    return $pdf->render();
    }
}
