<?php

namespace app\controllers;
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Venta;
use app\models\DetalleForm;
use app\models\ClienteForm;
use app\models\PagoForm;
use app\models\PagoSearch;
use yii\widgets\ActiveForm;
use kartik\mpdf\Pdf;

class AdminPagoController extends Controller
{
    public function behaviors()
    {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['lista','index','create','view','create-recibo','update','delete'],
              'rules' => [
                  [
                      'actions' => ['lista','index','create','create-recibo','view','update','delete'],
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
        $searchModel = new PagoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        /*$lista=ReciboForm::getVentasCredito();
        return $this->render('index', [
            'lista'=>$lista,
        ]);*/
       
    }
    
    public function actionCreate($id){
        $model=new PagoForm();
        $venta=Venta::getById($id);
        if(!isset($venta)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento");
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->fecha=explode(",", $model->fecha)[1];
            $venta->saldo=Yii::$app->request->post("saldo")-$model->monto;
            $model->tipo=0;
            if($model->create()){
                $venta->update();
                Yii::$app->session->setFlash('success','Cobro registrado exitósamente.');
                $id=$model->getLastInsertedId();
                return $this->redirect($url = (Yii::$app->user->identity->rol=="VENTAS") ? ['view', 'id' => $id]:['index']);
            }
        }
        $model->_usuario=Yii::$app->user->id;
        $model->_registrado=date('Y-m-d H:i:s');
        $model->fecha=Yii::$app->formatter->asDate(date('d-m-Y'),'php:l,d-m-Y');
        return $this->render('create', [
            'model'=>$model,
            'venta' => $venta,
        ]);
    }
    public function actionCreateRecibo(){
        $model=new PagoForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->tipo=0;
            $model->fecha=explode(",", $model->fecha)[1];
            $cliente=ClienteForm::getById($model->id_cliente);
            $cliente->deuda+=$model->monto;
            $cliente->update();
            if($model->create()){
                Yii::$app->session->setFlash('success','Cobro registrado exitósamente.');
                $id=$model->getLastInsertedId();

                return $this->redirect($url = (Yii::$app->user->identity->rol=="VENTAS") ? ['view', 'id' => $id]:['create-recibo']);
            }
        }
        $model->_usuario=Yii::$app->user->id;
        $model->_registrado=date('Y-m-d H:i:s');
        $model->fecha=Yii::$app->formatter->asDate(date('d-m-Y'),'php:l,d-m-Y');
        return $this->render('create-recibo', [
            'model'=>$model,
        ]);
    }

    public function actionUpdate($id){
       
        $model=PagoForm::getById($id);
        $venta=Venta::getById($model->id_venta);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento");
        }
        $model->fecha=date_format(date_create($model->fecha),"d-m-Y");
        if (!isset($venta)) {
            if ($model->load(Yii::$app->request->post())) {
                $model->tipo=0;
                if($model->update()){
                    Yii::$app->session->setFlash('success','Cobro registrado exitósamente.');
                    return $this->redirect(['view', 'id' => $id]);
                }
            }
            
            return $this->render('update-recibo', [
                'model'=>$model,
            ]);
        }
        else{
            
            if ($model->load(Yii::$app->request->post())) {
                $venta->saldo=Yii::$app->request->post("saldo")-$model->monto;
                if($model->update()){
                    $venta->update();
                    Yii::$app->session->setFlash('success','Cobro registrado exitósamente.');
                    return $this->redirect(['view', 'id' => $id]);
                }
            }
            $venta->saldo=$venta->saldo+$model->monto;
            return $this->render('update', [
                'model'=>$model,
                'venta' => $venta,
            ]);
        }
        
    }
    
    public function actionDelete($id){
        $model=PagoForm::getById($id);
        $venta=Venta::getById($model->id_venta);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento");
        }
        
        if ($model->_estado=='A') {
            $model->_estado='X';
            if ($model->delete()) {
                if (isset($venta->saldo)) {
                    $venta->saldo=$venta->saldo+$model->monto;
                }
                
                if ($venta->update()) {
                    Yii::$app->session->setFlash('success','Eliminado exitósamente.');
                    return $this->redirect(['lista']);
                }
            }
        }
        else
        {
           $model->_estado='A';
            if ($model->delete()) {
                if (isset($venta->saldo)) {
                    $venta->saldo=$venta->saldo-$model->monto;
                }
                
                if ($venta->update()) {
                    Yii::$app->session->setFlash('success','Eliminado exitósamente.');
                    return $this->redirect(['lista']);
                }
            } 
        }
        
    }
    public function actionViewModificar($id){
        $model=PagoForm::getById($id);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento");
        }
        $materiales=DetalleForm::getByIdVentaView($model->id_venta);
        return $this->render('view-modificar', [
            'model'=>$model,
            'materiales'=>$materiales,
        ]);
    }
    public function actionView($id){

        $this->imprimir($id);
        $model=PagoForm::getById($id);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento");
        }
        $materiales=DetalleForm::getByIdVentaView($model->id_venta);
        return $this->render('view', [
            'model'=>$model,
            'materiales'=>$materiales,
        ]);
    }
    public function actionLista(){
        $searchModel = new PagoSearch();
        $dataProvider = $searchModel->searchLista(Yii::$app->request->queryParams);

        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
    public function imprimir($id) {
        $model=PagoForm::getById($id);
        $materiales=DetalleForm::getByIdVentaView($model->id_venta);
        /*return $this->renderPartial('print-view',[
            'materiales'=>$materiales,
            'venta' => $venta,
            
        ]);*/
        $content = $this->renderPartial('view-print',[
            'materiales'=>$materiales,
            'model' => $model,
            
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
        'filename'=>'pdfs/recibo.pdf',
        // your html content input
        'content' => $content, 
        'marginLeft'=>10,
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

