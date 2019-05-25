<?php

/* @var $this yii\web\View */
/* @var $lista Array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\DetalleForm;

$this->title = $cliente->nombre;
$this->params['breadcrumbs'] = [
   ['label' => 'Ventas', 'url' => ['admin-venta/lista']],
   ['label' => 'Nota de Entrega', 'url' => ['admin-venta/index']], 
   ['label' => 'Lista Deudas'],
  ];
?>


<?php 
    $dataProvider = new \yii\data\ArrayDataProvider([
        'allModels' => $lista,
        'pagination' => [
            'pageSize'=> 20,
        ],
    ]);
?>
<h1><?= Html::encode($this->title) ?></h1>


<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'id' => 'venta-grid',
      'columns' => [
      [
        'attribute' => 'id_venta',
        'label'=>'Nro.'
      ],
      
      [
        'attribute'=>'fecha',
        'format'=> ['date', 'php:D, d/m/Y'],
        'label'=>'Fecha',
        'headerOptions' => ['width' => '100'],
      ],
      [
        'attribute' => 'numero',
        'label'=>'Nro. Venta Física',
        'headerOptions' => ['width' => '100'],
      ],
      [
        'attribute' => 'id_venta',
        'label'=>'Detalle',
        'format'=>'html',
        'value'=>function ($model){
          $materiales=DetalleForm::getByIdVentaView($model["id_venta"]);
          $tabla="<table class='table table-condensed'>";
          $tabla.="<tr><th>Cant</th><th>Mat</th><th>Prec</th><th>Sub</th></tr>";
          foreach ($materiales as $m) {

          $tabla.= "<tr>";
          
          $tabla.=  "<td class='col-md-1' ><p class='text-right' style='font-size:9pt'>".$m["cantidad"]."</p></td>";
          $tabla.=  "<td class='col-md-2' style='vertical-align:bottom;font-size:9pt'><p > ".$m["nombre"]."</p></td>";
          $precio=$m['costo']/$m['cantidad'];
          
          $tabla.=  "<td class='col-md-1' style='vertical-align:bottom;font-size:9pt'><p class='text-right'>".number_format($precio,2)."</p></td>";
         
          $tabla.=  "<td class='col-md-1'><p class='text-right' style='font-size:9pt'>".$m["costo"]."</p></td>";
          $tabla.= "</tr>";
          }
          $tabla.="</table>";
          return $tabla;
          
        }
      ],
      [
        'attribute' => 'total',
        'contentOptions' => ['class' => 'text-right'],
      ],
      [
        'attribute' => 'total_pagado',
        
        'contentOptions' => ['class' => 'text-right'],
      ],
      [
        'attribute' => 'saldo',
        'contentOptions' => ['class' => 'text-right'],
      ],
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{pay}',

        'buttons' => ['pay' => function($url, $model, $key){
            $url = ['admin-pago/create', 'id' => $model['id_venta']];
            return Html::a('<span class="glyphicon glyphicon-usd"></span>', $url, [
              'title' => Yii::t('app', 'Realizar Cobro'),
              'class'=>'btn btn-sm btn-info'
              ]);
          },
      
        ],
      ],

      ],
  ]); ?>