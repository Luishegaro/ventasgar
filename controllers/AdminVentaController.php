<?php

namespace app\controllers;
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Venta;
use app\models\ClienteForm;
use app\models\MaterialForm;
use app\models\DetalleForm;
use app\models\Contador;
use app\models\VentaSearch;
use app\models\PagoForm;
use kartik\mpdf\Pdf;

class AdminVentaController extends Controller
{
    public function behaviors()
    {
        return [
      'access' => [
          'class' => AccessControl::className(),
          'only' => ['index','create','pvt-update','principal','lista','view','update','rpt-ventas','delete'],
          'rules' => [
              [
                  'actions' => ['index','create','pvt-update','principal','lista','view','rpt-ventas','update','delete'],
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
        $model=new Venta();
        $materiales=MaterialForm::getMateriales();
        $clientes=ClienteForm::getLista();
        $detalle=new DetalleForm();
        $tipo=[0 => "Efectivo", 1 => "Crédito", 2 => "Retiro Mat."];

        if ($model->load(Yii::$app->request->post())) {

            $model->saldo=0;
            if ($model->tipo==1) {
                $model->saldo=$model->total-$model->cancelado;
            }
            if ($model->create()) {
                $id_venta=$model->getLastInsertedId();
                $lista_cant=Yii::$app->request->post('cantidad');
                $lista_precio=Yii::$app->request->post('precio');
                foreach ($lista_cant as $key => $value) {
                    $detalle->id_material=$key;
                    $detalle->id_venta=$id_venta;
                    $detalle->cantidad=$value;
                    $detalle->precio=$lista_precio[$key];
                    if ($value==0) {
                        continue;
                    }
                    $detalle->create();
                }
                
                if ($model->tipo==2) {
                    $cliente=ClienteForm::getById($model->id_cliente);
                    $cliente->deuda=$cliente->deuda-$model->total;
                    $cliente->update();
                }
                Yii::$app->session->setFlash('success','Registrado exitósamente.');
                return $this->redirect(['view-modificar', 'id' => $id_venta]);
            }
        }
        $model->_usuario=Yii::$app->user->id;
        $model->_registrado=date('Y-m-d H:i:s');
        $model->fecha=date('d-m-Y');
        return $this->render('index', [
            'materiales'=>$materiales,
            'venta' => $model,
            'clientes' => $clientes,
            'tipo'=>$tipo,
        ]);
       
    }
    public function actionPrincipal(){
        $model=new Venta();
        $materiales=MaterialForm::getMateriales();
        $clientes=ClienteForm::getLista();
        $detalle=new DetalleForm();
        $tipo=[0 => "Efectivo", 1 => "Crédito", 2 => "Retiro Mat."];

        if ($model->load(Yii::$app->request->post())) {
            $model->fecha=explode(",", $model->fecha)[1];
            $model->saldo=0;
            if ($model->tipo==1) {
                $model->saldo=$model->total-$model->cancelado;
            }
            if ($model->create()) {
                $id_venta=$model->getLastInsertedId();
                $lista_cant=Yii::$app->request->post('cantidad');
                $lista_precio=Yii::$app->request->post('precio');
                foreach ($lista_cant as $key => $value) {
                    $detalle->id_material=$key;
                    $detalle->id_venta=$id_venta;
                    $detalle->cantidad=$value;
                    $detalle->precio=$lista_precio[$key];
                    if ($value==0) {
                        continue;
                    }
                    $detalle->create();
                }
                
                if ($model->tipo==2) {
                    $cliente=ClienteForm::getById($model->id_cliente);
                    $cliente->deuda=$cliente->deuda-$model->total;
                    $cliente->update();
                }
                
                Yii::$app->session->setFlash('success','Registrado exitósamente.');
                return $this->redirect($url = (Yii::$app->user->identity->rol=="VENTAS") ? ['view', 'id' => $id_venta]:['principal']);
            }
        }
        $model->tipo=0;
        $model->_usuario=Yii::$app->user->id;
        $model->_registrado=date('Y-m-d H:i:s');
        $model->fecha=Yii::$app->formatter->asDate(date_create(Venta::getById($model->getLastInsertedId())->fecha),'php:l,d-m-Y');
        $pagina=(Yii::$app->user->identity->username=='contador')?"puntoVenta/principal_admin":"puntoVenta/principal";
        return $this->render($pagina, [
            'materiales'=>$materiales,
            'venta' => $model,
            'clientes' => $clientes,
            'tipo'=>$tipo,
        ]);
       
    }
    public function actionPvtUpdate($id){
        $tipo=[0 => "Efectivo", 1 => "Crédito", 2 => "Retiro Mat."];
        $model=Venta::getById($id);
        $materiales=MaterialForm::getMaterialesByIdRecibo($id);
        $clientes=ClienteForm::getClientes();
        $detalle=new DetalleForm();
        /*$cli=$this->actionDeuda($recibo->id_cliente);*/

        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ".$id);
        }
        

        if ($model->load(Yii::$app->request->post())) {
            $model->saldo=0;
            if ($model->tipo==1) {
                $model->saldo=$model->total-$model->cancelado;
            }
            if ($model->update()) {
                
                $detalle->deleteByIdVenta($id);
                $lista_cant=Yii::$app->request->post('cantidad');
                $lista_precio=Yii::$app->request->post('precio');
                foreach ($lista_cant as $key => $value) {
                    $detalle->id_material=$key;
                    $detalle->id_venta=$id;
                    $detalle->cantidad=$value;
                    $detalle->precio=$lista_precio[$key];
                    if ($value==0) {
                        continue;
                    }
                    $detalle->create();
                    
                }
                Yii::$app->session->setFlash('success','Recibo '.$model->id_venta.' registrado exitósamente.');
                return $this->redirect($url = (Yii::$app->user->identity->rol=="VENTAS") ? ['view', 'id' => $id]:['lista']);
            }
            
            
        }
        $pagina=(Yii::$app->user->identity->username=='contador')?"puntoVenta/update_admin":"puntoVenta/update";
        return $this->render($pagina, [
            'materiales'=>$materiales,
            'venta' => $model,
            'clientes' => $clientes,
            'tipo'=>$tipo,
        ]);

    }
    public function actionDeuda($id){
        $cantidad=MaterialForm::getCantidadByCliente($id);
        $d = Venta::getTotalSaldo($id);
        if(!isset($d)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ");
        }
        $cliente=ClienteForm::getById($id);
        $data = array('deuda' => $d,'favor'=> $cliente->deuda,);
        foreach ($cantidad as $c) {
            $data[$c["id_material"]]=$c["cantidad"];
        }
        return json_encode($data);
    }
    public function actionGetDeuda($id_cliente){
        $cli=ClienteForm::getById($id_cliente);
        if(!isset($cli)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ");
        }
        $lista=Venta::getVentaByIdCliente($id_cliente);
        return $this->renderAjax('lista-deudas',[
            'lista' => $lista,
            'cliente'=>$cli,
            ]);
    }
    public function actionGetSaldo($id_cliente){
        $cli=ClienteForm::getById($id_cliente);
        if(!isset($cli)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ");
        }
        $lista=PagoForm::getSaldoByIdCliente($id_cliente);
        return $this->renderAjax('lista-saldo',[
            'lista' => $lista,
            'cliente'=>$cli,
            ]);
    }
    public function actionLista(){
        $searchModel = new VentaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel->load(Yii::$app->request->get());
        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
    
    public function actionUpdate($id){
        $tipo=[0 => "Efectivo", 1 => "Crédito", 2 => "Retiro Mat."];
        $model=Venta::getById($id);
        $materiales=MaterialForm::getMaterialesByIdRecibo($id);
        $clientes=ClienteForm::getClientes();
        $detalle=new DetalleForm();
        /*$cli=$this->actionDeuda($recibo->id_cliente);*/

        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento ".$id);
        }
        $pago=Contador::countById('pago','id_pago','id_venta',$id);
        if ($pago>0) {
            Yii::$app->session->setFlash('error','La Nota de venta tiene pagos, Elimine todo los pagos para proceder con la modificación');
            return $this->redirect(['lista']);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->saldo=0;
            if ($model->tipo==1) {
                $model->saldo=$model->total-$model->cancelado;
            }
            if ($model->update()) {
                
                $detalle->deleteByIdVenta($id);
                $lista_cant=Yii::$app->request->post('cantidad');
                $lista_precio=Yii::$app->request->post('precio');
                foreach ($lista_cant as $key => $value) {
                    $detalle->id_material=$key;
                    $detalle->id_venta=$id;
                    $detalle->cantidad=$value;
                    $detalle->precio=$lista_precio[$key];
                    if ($value==0) {
                        continue;
                    }
                    $detalle->create();
                    
                }
                Yii::$app->session->setFlash('success','Recibo '.$model->id_venta.' registrado exitósamente.');
                return $this->redirect(['view-modificar', 'id' => $id]);
            }
            
            
        }
        return $this->render('update', [
            'materiales'=>$materiales,
            'venta' => $model,
            'clientes' => $clientes,
            'tipo'=>$tipo,
        ]);

    }
    public function actionDelete($id){
        $model=Venta::getById($id);
        $pago=Contador::countById('pago','id_pago','id_venta',$id);
        if(!isset($model)){
            throw new \yii\web\ForbiddenHttpException("No se encontró el elemento");
        }
        if($pago>0){
            Yii::$app->session->setFlash('error','La Nota de venta tiene pagos, no se pudo Eliminar');
            $this->redirect(['lista']);
        }
        else{
            $model->_estado=($model->_estado=='X')?'A':'X';
            if ($model->delete()) {
                Yii::$app->session->setFlash('success','Recibo eliminado exitósamente.');
                $this->redirect(['lista']);
            }
        }
        
    }
    public function actionView($id){
        $this->imprimir($id);
        $venta=Venta::getByIdView($id);
        $materiales=DetalleForm::getByIdVentaView($id);
        return $this->render('view', [
            'materiales'=>$materiales,
            'venta' => $venta,
            
        ]);
    }
    public function actionViewModificar($id){
        $venta=Venta::getByIdView($id);
        $materiales=DetalleForm::getByIdVentaView($id);
        return $this->render('view-modificar', [
            'materiales'=>$materiales,
            'venta' => $venta,
            
        ]);
    }
    function imprimir($id) {
        $venta=Venta::getByIdView($id);
        $materiales=DetalleForm::getByIdVentaView($id);
        /*return $this->renderPartial('print-view',[
            'materiales'=>$materiales,
            'venta' => $venta,
            
        ]);*/
        $content = $this->renderPartial('print-view',[
            'materiales'=>$materiales,
            'venta' => $venta,
            
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
        'filename'=>'pdfs/ticket.pdf',
        'marginLeft'=>9,
        'marginTop'=>3,
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '
        #tabladiv {
            width:230px;
        }
        #tbdetalle th{
            border-bottom:0.1pt solid black;
        }
        #tbdetalle #tdtot{
            border-top:0.3pt solid black;
        }
        
        #tbdetalle td:nth-child(1){
            text-align:right;
        }
        #tbdetalle td:nth-child(2){
            text-align:left;
        }
        #tbdetalle td:nth-child(3){
            text-align:right;
        }
        #tbdetalle td:nth-child(4){
            text-align:right;
        }
        ', 
        
    ]);
    
    // return the pdf output as per the destination setting
    return $pdf->render();
    }
    public function actionRptVentas(){
        $searchModel = new VentaSearch();

        $data = $searchModel->get_rpt_ventas(Yii::$app->request->queryParams);
        $materiales = $searchModel->get_rpt_materiales(Yii::$app->request->queryParams);
        $recibos=$searchModel->get_rpt_recibos(Yii::$app->request->queryParams);
        $gastos=$searchModel->get_rpt_gastos(Yii::$app->request->queryParams);
        $providerMateriales = new \yii\data\ArrayDataProvider([
            'allModels' => $materiales,
        ]);
        $providerRecibos = new \yii\data\ArrayDataProvider([
            'allModels' => $recibos,
        ]);
        $providerGastos = new \yii\data\ArrayDataProvider([
            'allModels' => $gastos,
            
        ]);
        return $this->render('rpt-ventas-new', [
            'searchModel' => $searchModel,
            'data' => $data,
            'providerRecibos' => $providerRecibos,
            'providerGastos' => $providerGastos,
            'providerMateriales' => $providerMateriales,
        ]);
    }
    public function actionRptDiario(){
        $searchModel = new VentaSearch();

        $data = $searchModel->get_rpt_ventas(Yii::$app->request->queryParams);
        $materiales = $searchModel->get_rpt_materiales(Yii::$app->request->queryParams);
        $recibos=$searchModel->get_rpt_recibos(Yii::$app->request->queryParams);
        $gastos=$searchModel->get_rpt_gastos(Yii::$app->request->queryParams);
        $providerMateriales = new \yii\data\ArrayDataProvider([
            'allModels' => $materiales,
            'pagination'=>false,
        ]);
        $providerRecibos = new \yii\data\ArrayDataProvider([
            'allModels' => $recibos,
            'pagination'=>false,
        ]);
        $providerGastos = new \yii\data\ArrayDataProvider([
            'allModels' => $gastos,
            'pagination'=>false,
            
        ]);
        return $this->render('reportes/rpt-diario', [
            'searchModel' => $searchModel,
            'data' => $data,
            'providerRecibos' => $providerRecibos,
            'providerGastos' => $providerGastos,
            'providerMateriales' => $providerMateriales,
        ]);
        
        
    }

    /*public function actionPrintDiario(){
        $searchModel = new VentaSearch();

        $data = $searchModel->get_rpt_ventas(Yii::$app->request->queryParams);
        $materiales = $searchModel->get_rpt_materiales(Yii::$app->request->queryParams);
        $recibos=$searchModel->get_rpt_recibos(Yii::$app->request->queryParams);
        $gastos=$searchModel->get_rpt_gastos(Yii::$app->request->queryParams);
        $providerMateriales = new \yii\data\ArrayDataProvider([
            'allModels' => $materiales,
            'pagination'=>false,
        ]);
        $providerRecibos = new \yii\data\ArrayDataProvider([
            'allModels' => $recibos,
            'pagination'=>false,
        ]);
        $providerGastos = new \yii\data\ArrayDataProvider([
            'allModels' => $gastos,
            'pagination'=>false,
            
        ]);
        return $this->renderPartial('reportes/rpt-diario', [
            'searchModel' => $searchModel,
            'data' => $data,
            'providerRecibos' => $providerRecibos,
            'providerGastos' => $providerGastos,
            'providerMateriales' => $providerMateriales,
        ]);
    }*/
    
}

