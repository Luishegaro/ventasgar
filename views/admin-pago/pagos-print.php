<?php

/* @var $this yii\web\View */
/* @var $lista Array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\components\PTotal;


?>

<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'id' => 'venta-grid',
      'showFooter' => true,
      'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline'],
      'columns' => [
      [
        'attribute' => 'id_venta',
        'label'=>'Nro. Nota de Venta'
      ],
      [
        'attribute'=>'fecha',
        'format'=>'date',
        'label'=>'Fecha de Venta',
      ], 
      [
        'attribute' => 'nombre',
        'label'=>'Cliente'
      ],
      
      [
        'attribute' => 'total',
        'contentOptions' => ['class' => 'text-right'],
        'footer'=>PTotal::pageTotal($dataProvider->getModels(),'total'),
        'footerOptions' => ['class' => 'text-right'],

      ],
      [
        'attribute' => 'total_pagado',
        'contentOptions' => ['class' => 'text-right'],
        'footer'=>PTotal::pageTotal($dataProvider->getModels(),'total_pagado'),
        'footerOptions' => ['class' => 'text-right'],
      ],
      [
        'attribute' => 'saldo',
        'contentOptions' => ['class' => 'text-right'],
        'footer'=>PTotal::pageTotal($dataProvider->getModels(),'saldo'),
        'footerOptions' => ['class' => 'text-right'],
      ],
      ],
  ]); ?>
