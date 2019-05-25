<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\PTotal;
use app\models\Reporte;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CliSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div id="ventas-grid">

    <h4 class="text-center">Resumen de Ingresos y Gastos</h4>
    <p class="text-center"><b>Desde: <?= Yii::$app->formatter->format($model->fecha_inicio, 'date')  ?> Hasta: <?= Yii::$app->formatter->format($model->fecha_fin, 'date')  ?></b><br><b>Bolivianos</b><br><button type="button" class="btn btn-danger" onclick="printData()" ><i class="glyphicon glyphicon-print"></i> Imprimir</button></p>
    <?php 
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $resumen,
            'pagination' => false
        ]);

      ?>
      <?= GridView::widget([
              'dataProvider' => $dataProvider,
              'showFooter'=>TRUE,
              'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
              'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                  [

                    "attribute"=>"fecha",
                    "format"=>'date',
                  ],
                  [
                    "attribute"=>"dia",
                    "value"=>function($model)
                    {
                      $f = Yii::$app->formatter;
                      return $f->asDate($model["fecha"], 'php:l');
                    }
                  ],
                  [

                    "attribute"=>"fecha",
                    "label"=>'Material',
                    "value"=>function($model)
                    {
                      $material=Reporte::getMaterialByFecha($model["fecha"]);
                      $tab="<table class='table'>
                        <tr>
                          <th class='text-center' style='font-size:9pt'>Detalle</th>
                          <th class='text-center' style='font-size:9pt'>m3</th>
                          <th class='text-center' style='font-size:9pt'>Importe</th>
                        </tr>";
                      foreach ($material as $m) {
                        $tab.="<tr>
                          <td style='font-size:9pt'>".$m['nombre']."</td>
                          <td class='text-right' style='font-size:9pt'>".$m['cantidad']."</td>
                          <td class='text-right' style='font-size:9pt'>".$m['precio']."</td>
                        </tr>";
                      }
                      $tab.="</table>";
                      return $tab;
                      
                    },
                    "format"=>"html",
                  ],
                  
                  
                  [
                    "attribute"=>"efectivo",
                    "label"=>"Vtas. Contado",
                    'format'=>['decimal',2],
                    'contentOptions' => ['class' => 'text-right'],
                    'footer'=>Yii::$app->formatter->asDecimal(PTotal::pageTotal($dataProvider->allModels,'efectivo'),2),
                    'footerOptions' => ['class' => 'text-right'],
                  ],
                  [
                    "attribute"=>"credito",
                    "label"=>"Vtas. Crédito",
                    'contentOptions' => ['class' => 'text-right'],
                    'footer'=>Yii::$app->formatter->asDecimal(PTotal::pageTotal($dataProvider->allModels,'credito'),2),
                    'footerOptions' => ['class' => 'text-right'],
                  ],
                  [
                    "attribute"=>"cobro",
                    "label"=>"Cobro a Clientes",
                    'format'=>['decimal',2],
                    'contentOptions' => ['class' => 'text-right'],
                    'footer'=>Yii::$app->formatter->asDecimal(PTotal::pageTotal($dataProvider->allModels,'cobro'),2),
                    'footerOptions' => ['class' => 'text-right'],
                  ],
                  [
                    "attribute"=>"gasto",
                    "label"=>"Gastos",
                    'format'=>['decimal',2],
                    'contentOptions' => ['class' => 'text-right'],
                    'footer'=>Yii::$app->formatter->asDecimal(PTotal::pageTotal($dataProvider->allModels,'gasto'),2),
                    'footerOptions' => ['class' => 'text-right'],
                  ],
                  
                  
              ],

          ]); ?>
</div>

<style type="text/css">
    @media print {
      body * {
        visibility: collapse;
      }
      #section-to-print, #section-to-print * {
        visibility: visible;
      }
      #section-to-print {
        position: absolute;
        left: 0;
        top: 0;
      }
      
    }
    tfoot {
      background-color: #e0e0d1;
      
    }
</style>
<script type="text/javascript">
    function printData()
    { 
      var ventas = document.getElementById("ventas-grid").outerHTML;
      var print=document.getElementById("section-to-print");
      print.innerHTML = ventas;
      window.print();
      print.innerHTML = "";
    }
    
</script>
