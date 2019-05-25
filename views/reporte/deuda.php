<?php

use yii\helpers\Html;
use app\models\ClienteForm;
use app\models\PagoForm;
use app\models\DetalleForm;
use app\components\PTotal;
use app\models\Venta;
use yii\grid\GridView;
/*$ventas array ventas con deuda,
 $model array de id clientes*/
?>
<h3 style="text-align: center;">Reporte de Deudas</h3>
<p style="text-align: center;"><b><b>Bolivianos</b>
</p>
<?php foreach ($model->id_cliente as $value): ?>
  <h4><strong><?= ClienteForm::getById($value)->nombre ?></strong></h4>
    <?php 
      $ventas=Venta::getVentaByIdCliente($value);
      $dataProvider = new \yii\data\ArrayDataProvider([
        'allModels' => $ventas,
        'pagination' => false,
    ]);
    ?>
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'showFooter'=>TRUE,

      'columns' => [
      ['class' => 'yii\grid\SerialColumn','headerOptions' => ['style'=>'background-color: #A4A4A4;color: white;'],],
      /*[
        'attribute' => 'id_venta',
        'label'=>'Nro.',
        'contentOptions' => ['style' => 'font-size:9pt;'],
        'headerOptions' => ['style'=>'background-color: #A4A4A4;color: white;'],
      ],*/
      
      [
        'attribute'=>'fecha',
        'format'=> ['date', 'php:D, d/m/Y'],
        'label'=>'Fecha',
        'headerOptions' => ['width' => '100','style'=>'background-color: #A4A4A4;color: white;'],
        'contentOptions' => ['style' => 'font-size:9pt;']
      ],
      [
        'attribute' => 'numero',
        'label'=>'NE',
        'headerOptions' => ['style'=>'background-color: #A4A4A4;color: white;'],
        'contentOptions' => ['style' => 'font-size:9pt;'],
      ],
      [
        'attribute' => 'id_venta',
        'label'=>'Detalle',
        'format'=>'html',
        'contentOptions' => ['style' => 'font-size:9pt;','class' => 'text-center'],
        'headerOptions' => ['style'=>'background-color: #A4A4A4;color: white;'],
        'value'=>function ($model){
          $materiales=DetalleForm::getByIdVentaView($model["id_venta"]);
          $tabla="<table class='detalle-table'>";
          $tabla.="<tr ><th style='font-size:8pt'>Cant</th><th style='font-size:8pt'>Mat</th><th style='font-size:8pt'>Prec</th><th style='font-size:8pt'>Sub</th></tr>";
          foreach ($materiales as $m) {

          $tabla.= "<tr>";
          
          $tabla.=  "<td><div style='font-size:8pt' align='right'>".$m["cantidad"]."</div></td>";
          $tabla.=  "<td style='vertical-align:bottom;font-size:8pt'><div style='font-size:8pt' align='right'>".$m["nombre"]."</div></td>";
          $precio=$m['costo']/$m['cantidad'];
          
          $tabla.=  "<td style='vertical-align:bottom;font-size:8pt'><div style='font-size:8pt' align='right'>".number_format($precio,2)."</div></td>";
         
          $tabla.=  "<td class='col-md-1'><div style='font-size:8pt' align='right'>".$m["costo"]."</div></td>";
          $tabla.= "</tr>";
          }
          $tabla.="</table>";
          return $tabla;
          
        }
      ],
      [
        'attribute' => 'total',
        'contentOptions' => ['class' => 'text-right','style' => 'font-size:9pt;'],
        'headerOptions' => ['style'=>'background-color: #A4A4A4;color: white;'],
        'footer'=>number_format(PTotal::pageTotal($dataProvider->allModels,'total'),2),
        'footerOptions'=>['class' => 'text-right','style'=>'font-size:9pt;font-weight:bold;text-decoration: underline'],
      ],
      [
        'attribute' => 'cancelado',
        'headerOptions' => ['style'=>'background-color: #A4A4A4;color: white;'],
        'contentOptions' => ['class' => 'text-right','style' => 'font-size:9pt;'],
        'footer'=>number_format(PTotal::pageTotal($dataProvider->allModels,'cancelado'),2),
        'footerOptions'=>['class' => 'text-right','style'=>'font-size:9pt;font-weight:bold;text-decoration: underline'],
      ],
      [
        'attribute' => 'saldo',
        'contentOptions' => ['class' => 'text-right','style' => 'font-size:9pt;'],
        'headerOptions' => ['style'=>'background-color: #A4A4A4;color: white;'],
        'footer'=>number_format(PTotal::pageTotal($dataProvider->allModels,'saldo'),2),
        'footerOptions'=>['class' => 'text-right','style'=>'font-size:9pt;font-weight:bold;text-decoration: underline'],
      ],
      [
        'attribute' => 'id_venta',
        'contentOptions' => ['class' => 'text-center','style' => 'font-size:9pt;'],
        'headerOptions' => ['style'=>'background-color: #A4A4A4;color: white;'],
        'label'=>'Pagos',
        'format'=>'html',
        'value'=>function($model){
          $pagos=PagoForm::getPagosByIdVenta($model["id_venta"]);
          $tabla_pagos="<div>-</div>";
          $cont=0;
          if ($pagos!=[]) {
            $tabla_pagos="<table width='300px'>
                  <tr>
                    <th style='font-size:8pt'>#</th>
                    <th style='font-size:8pt'>Fecha</th>
                    <th style='font-size:8pt'>Monto</th>
                  </tr>";
            foreach ($pagos as $p) {
              $cont++;
              $tabla_pagos.="<tr>
                      <td style='font-size:8pt'>".$cont."</td>
                      <td><div style='font-size:8pt'>". Yii::$app->formatter->format($p["fecha"], ['date', 'php:D, d/m/Y']) ."</div></td>
                      <td style='text-align: right;'><div align='right' style='font-size:8pt'>". $p["monto"] ."</div></td>
                    </tr>";
            }
            $tabla_pagos.="<tr>
                    <td colspan='2' style='font-size:8pt'><strong>Total Pagado</strong></td>
                    <td style='text-align: right;'><p align='right' style='font-size:8pt'>". number_format(PTotal::pageTotal($pagos,'monto'),2)."</p></td>
                  </tr>
                </table>";
            return $tabla_pagos;
          }
          else{
            return $tabla_pagos;
          }
        }
      ],

      ],
  ]); ?>
  <hr>
<?php endforeach ?>
