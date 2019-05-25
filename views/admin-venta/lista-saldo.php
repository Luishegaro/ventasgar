<?php

/* @var $this yii\web\View */
/* @var $lista Array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

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
            'pageSize'=> 12,
        ],
    ]);
?>
<h1><?= Html::encode($this->title) ?></h1>


<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'id' => 'venta-grid',
      'columns' => [
      [
        'attribute' => 'id_pago',
        'label'=>'Nro.'
      ],
      [
        'attribute' => 'fecha',
        'label'=>'Fecha',
        'format'=> ['date', 'php:D, d/m/Y'],
      ],
      [
        'attribute' => 'concepto',
      ],
      [
        'attribute' => 'monto',
        'label'=>'Ingreso Bs.',
        'contentOptions' => ['class' => 'text-right'],
      ],
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}',
        'buttons' => ['view' => function($url, $model, $key){
            $url = ['admin-pago/view', 'id' => $model['id_pago']];
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
              'title' => Yii::t('app', 'Ver'),
              ]);
          },
          
        ],
      ],

      ],
  ]); ?>