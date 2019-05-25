<?php

/* @var $this yii\web\View */
/* @var $lista Array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\components\PTotal;

$this->title = 'HISTORIAL DE COBROS';
$this->params['breadcrumbs'] = null;
?>


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

<h3 class="text-center"> <?= Html::encode($this->title) ?></h3>
<div class="panel panel-default">
  <div class="panel-body">
    


<?php echo $this->render('_search-lista', ['model' => $searchModel]); ?>

<!--
<p>
    <?= Html::a('Crear Recibo',['create-recibo'], ['class' => 'btn btn-success']) ?>
</p>-->
  <div class="table-responsive">
    <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'id' => 'creditos-grid',
          'showFooter' => true,
          'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline'],
          'rowOptions'=>function($model){
                  if ($model["_estado"]=='X') {
                    return ['class'=>'danger'];
                  }
              },
          'columns' => [
          [
            'label'=>'Nro.',
            'attribute'=>'id_pago',
          ],
          [
            'attribute'=>'fecha',
            'format'=> ['date', 'php:D, d/m/Y']
          ],
          [
            'label'=>'Recibi de',
            'attribute'=>'nombre',
          ],
          [
            'label'=>'Por Concepto de',
            'attribute' => 'concepto',
            'format'=>'html'

            
          ],
          [
            'attribute' => 'monto',
            'contentOptions' => ['class' => 'text-right'],
            'footer'=>Yii::$app->formatter->asDecimal(PTotal::pageTotal($dataProvider->getModels(),'monto'),2),
            'footerOptions' => ['class' => 'text-right'],
          ],
          [
            'label'=>'Estado',
            'attribute'=>'_estado',
            'value'=>function($model){
                switch ($model["_estado"]) {
                    case 'A':
                        return "Activo";
                        break;
                    case 'X':
                        return "Anulada";
                        break;
                    
                }
            }
          ],
          [
              'class' => 'yii\grid\ActionColumn', 
              'template' => '{view} {update} {delete}',

              'buttons' => ['view' => function($url, $model, $key){
                  $url = ['view', 'id' => $model['id_pago']];
                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('app', 'Ver'),
                    'class'=>'btn btn-sm btn-primary','style'=>'margin-left:10px;',
                    ]);
                },
                'update' => function($url, $model, $key){
                  $url = ['update', 'id' => $model['id_pago']];
                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app', 'Modificar'),
                    'class'=>'btn btn-sm btn-warning','style'=>'margin-left:10px;',
                    ]);
                },

                'delete' => function($url, $model, $key){
                  $url = ['delete', 'id' => $model['id_pago']];
                  if ($model['_estado']=='A') {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('app', 'Eliminar'),
                    'data-confirm' => Yii::t('app', 'Esta seguro de elimnar este item?'),
                    'class'=>'btn btn-sm btn-danger','style'=>'margin-left:10px;',
                    ]);
                  }
                  else
                  {
                    return Html::a('<span class="glyphicon glyphicon-repeat"></span>', $url, [
                    'title' => Yii::t('app', 'Reestablecer'),
                    'data-confirm' => Yii::t('app', 'Esta seguro de reestablecer este item?'),
                    'class'=>'btn btn-sm btn-info','style'=>'margin-left:10px;',
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