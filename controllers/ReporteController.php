<?php

namespace app\controllers;
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
use app\models\PagoForm;
use app\models\ClienteForm;
use app\models\Reporte;
use yii\web\NotFoundHttpException;
use kartik\mpdf\Pdf;

class ReporteController extends Controller
{
    public function behaviors()
    {
        return [
      'access' => [
          'class' => AccessControl::className(),
          'only' => ['deuda','ingreso'],
          'rules' => [
              [
                  'actions' => ['deuda','ingreso'],
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

    public function actionDeuda(){
        $clientes=ClienteForm::getClientesConDeuda();
        $searchModel = new Reporte();
        if ($searchModel->load(Yii::$app->request->get())) {
          if (!isset($searchModel->id_cliente)) {
            throw new NotFoundHttpException('The requested page does not exist.');
          }
              $content = $this->renderPartial('deuda',[
                  'model' => $searchModel,
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
              'destination' => Pdf::DEST_BROWSER, 
              'filename'=>'pdfs/rep_deuda.pdf',
              // your html content input
              'content' => $content, 
              'marginLeft'=>8,
              'marginTop'=>3,
              'marginBottom'=>3,
              'marginRight'=>8,

              // format content from your own css file if needed or use the
              // enhanced bootstrap css built by Krajee for mPDF formatting 
              'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
              // any css to be embedded if required
              'cssInline' => '
                #main-table {
                    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                }

                #main-table td, #main-table th {
                    border: 1px solid #ddd;
                    padding: 8px;
                }


                #main-table th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    text-align: left;
                    background-color: #A4A4A4;
                    color: white;
                }
                #detalle-table th, td {
                    padding: 8px;
                }
                #main-table th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    text-align: left;
                    background-color: #A4A4A4;
                    color: white;
                }
              ',
               // set mPDF properties on the fly
              
               // call mPDF methods on the fly
              
          ]);
          
          // return the pdf output as per the destination setting
          return $pdf->render();
            
        }
        

        return $this->render('search', [
            'model' => $searchModel,
            'clientes' => $clientes,
        ]);
    }
    public function actionIngreso()
    {
      $searchModel = new Reporte();
      if ($searchModel->load(Yii::$app->request->get())) {
        $resumen=$searchModel->getResumen();
        $materiales=$searchModel->getResumenMateriales();
        return $this->render('search_ingreso', [
            'model' => $searchModel,
            'resumen'=>$resumen,
            'materiales'=>$materiales,
        ]);
      }
      return $this->render('search_ingreso', [
            'model' => $searchModel,
        ]);
    }
    
}

