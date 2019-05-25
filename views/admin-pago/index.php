<?php

/* @var $this yii\web\View */
/* @var $lista Array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\components\PTotal;
use app\models\DetalleForm;

$this->title = 'VENTAS A CRÉDITO PENDIENTES';
$this->params['breadcrumbs'] = null;
?>


<!--#c18d43-->

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif; ?> 
<h4 class="text-center"><?= Html::encode($this->title) ?></h4>   
<div class="panel panel-default">
  <div class="panel-body">
    


<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<div id="section-to-print">
  <div class="table-responsive">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'id' => 'venta-grid',
      'showFooter' => true,
      'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline'],
      'columns' => [
      [
        'attribute' => 'id_venta',
        'label'=>'Nro. Venta Sist.',
        'headerOptions' => ['width' => '100'],
      ],
      [
        'attribute'=>'fecha',
        'format'=> ['date', 'php:D, d/m/Y'],
        'label'=>'Fecha de Venta',
        'headerOptions' => ['width' => '100'],
      ],
      [
        'attribute' => 'numero',
        'label'=>'Nro. Venta Física',
        'headerOptions' => ['width' => '100'],
      ],
      [
        'attribute' => 'nombre',
        'label'=>'Cliente'
      ],
      [
        'attribute' => 'id_venta',
        'label'=>'Detalle',
        'format'=>'html',
        'value'=>function ($model){
          $materiales=DetalleForm::getByIdVentaView($model["id_venta"]);
          $tabla="<table class='table table-bordered'>";
          $tabla.="<tr><th>Cant</th><th>Mat</th><th>Prec</th><th>Sub</th></tr>";
          foreach ($materiales as $m) {

          $tabla.= "<tr>";
          
          $tabla.=  "<td class='col-md-1' ><p class='text-right' style='font-size:9pt'>".$m["cantidad"]."</p></td>";
          $tabla.=  "<td class='col-md-2' style='vertical-align:bottom;font-size:8pt'><p > ".$m["nombre"]."</p></td>";
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
        'footer'=>Yii::$app->formatter->format(PTotal::pageTotal($dataProvider->getModels(),'total'),['decimal',2]),
        'footerOptions' => ['class' => 'text-right'],

      ],
      [
        'attribute' => 'total_pagado',
        'contentOptions' => ['class' => 'text-right'],
        'footer'=>Yii::$app->formatter->format(PTotal::pageTotal($dataProvider->getModels(),'total_pagado'),['decimal',2]),
        'footerOptions' => ['class' => 'text-right'],
      ],
      [
        'attribute' => 'saldo',
        'contentOptions' => ['class' => 'text-right'],
        'footer'=>Yii::$app->formatter->format(PTotal::pageTotal($dataProvider->getModels(),'saldo'),['decimal',2]),
        'footerOptions' => ['class' => 'text-right'],
      ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => "<div class='ocultar'> {view} {update} {pay}</div>",
            'buttons' => ['pay' => function($url, $model, $key){
                $url = ['create', 'id' => $model['id_venta']];
                return Html::a('<span class="glyphicon glyphicon-usd"></span>', $url, [
                  'title' => Yii::t('app', 'Realizar Cobro'),
                  'class'=>'btn btn-sm btn-info','style'=>'margin-left:10px;',
                  ]);
              },
              'view' => function($url, $model, $key){
                $url = ['admin-venta/view', 'id' => $model['id_venta']];
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                  'title' => Yii::t('app', 'Ver'),
                  'class'=>'btn btn-sm btn-primary','style'=>'margin-left:10px;',
                  ]);
              },
              'update' => function($url, $model, $key){
                $url = ['admin-venta/pvt-update', 'id' => $model['id_venta']];
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                  'title' => Yii::t('app', 'Modificar'),
                  'class'=>'btn btn-sm btn-warning','style'=>'margin-left:10px;',
                  ]);
              },
            ],
        ],
      ],
  ]); ?>
</div>
</div>
</div>
</div>
  <style type="text/css">
    @media print {
      body * {
        visibility: hidden;
      }
      #section-to-print, #section-to-print * {
        visibility: visible;
      }
      .ocultar{
        display:none;
      }
      .pagination{
        display:none;
      }
      #section-to-print {
        position: absolute;
        left: 0;
        top: 0;
      }
      
    }
    
</style>
<script type="text/javascript">
    function printData()
    { 
      
      window.print();
      
    }
</script>