<?php

/* @var $this yii\web\View */
/* @var $lista Array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\components\PTotal;
use app\models\Venta;

$this->title = 'HISTORIAL DE VENTAS';
$this->params['breadcrumbs'] = null;
?>
<h4 class="text-center"><?= Html::encode($this->title) ?></h4>
<div class="panel panel-default">
  <div class="panel-body">
    
<?php echo $this->render('_search', ['model' => $searchModel]); ?>


<!--<p>
    <?= Html::a('Nueva Venta',['principal'], ['class' => 'btn btn-success']) ?>
</p>-->

<div class="table-responsive">
  

<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'id' => 'venta-grid',
      'showFooter'=>TRUE,
      'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline'],
      'rowOptions'=>function($model){
          if ($model["_estado"]=='X') {
            return ['class'=>'danger'];
          }
      },
      'columns' => [
      [
        'attribute'=>'id_venta',
        'label'=>'Nro.',
      ],
      [
        'attribute'=>'fecha',
        'format'=> ['date', 'php:D, d/m/Y']
      ],
      'placa',
      [
        'attribute'=>'nombre',
        'footer'=>'Totales',
      ],
      [
        'attribute' => 'tipo',
        'value' => function($model, $key, $index, $widget) {
          switch ($model["tipo"]) {
            case 0:
              return "Efectivo";
              break;
            case 1:
              return "Por Cobrar";
            break;
            case 2:
              return "Retiro de Material";
            break;
          }
        }
      ],
      [
        'attribute' => 'total',
        'format'=>['decimal',2],
        'contentOptions' => ['class' => 'text-right'],
        'footerOptions' => ['class' => 'text-right'],
        'footer'=>Yii::$app->formatter->format(PTotal::pageTotal($dataProvider->getModels(),'total'),['decimal',2]),
      ],
      [
        'attribute' => 'cancelado',
        'format'=>['decimal',2],
        'contentOptions' => ['class' => 'text-right'],
        'footerOptions' => ['class' => 'text-right'],
        'footer'=>Yii::$app->formatter->format(PTotal::pageTotal($dataProvider->getModels(),'cancelado'),['decimal',2]),
      ],
      'observacion:ntext',
      [
        'attribute'=>'_registrado',
        'format'=> ['date', 'php:d/m/Y H:m:s']
      ],
      '_usuario',
      [
        'attribute'=>'_estado',
        'label'=>'Estado',
          'value' => function($model, $key, $index, $widget) {
            switch ($model["_estado"]) {
              case "A":
                return "Activo";
                break;
              case "X":
                return "Anulado";
              break;
            }
          }
      ],

          [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{view} {update} {delete}',

              'buttons' => ['view' => function($url, $model, $key){
                  $url = ['view', 'id' => $model['id_venta']];
                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('app', 'Ver'),'class'=>'btn btn-sm btn-primary','style'=>'margin-left:10px;'
                    ]);
                },
                'update' => function($url, $model, $key){
                  $url = ['pvt-update', 'id' => $model['id_venta']];
                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app', 'Modificar'),'class'=>'btn btn-sm  btn-warning'
                    ,'style'=>'margin-left:10px;'
                    ]);
                },
                'delete' => function($url, $model, $key){
                  $url = ['delete', 'id' => $model['id_venta']];
                  if ($model['_estado']=='A') {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('app', 'Eliminar'),'class'=>'btn btn-sm btn-danger'
                    ,'style'=>'margin-left:10px;',
                    'data-confirm' => Yii::t('app', 'Esta seguro de elimnar este item?'),
                    ]);
                  }
                  else
                  {
                    return Html::a('<span class="glyphicon glyphicon-repeat"></span>', $url, [
                    'title' => Yii::t('app', 'Reestablecer'),
                    'class'=>'btn btn-sm btn-danger','style'=>'margin-left:10px;',
                    'data-confirm' => Yii::t('app', 'Esta seguro de reestablecer este item?'),
                    ]);
                  }
                },
              ],
          ],
      ],
  ]); ?>
  </div>
  </div>
    </div>