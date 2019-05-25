<?php

/* @var $this yii\web\View */
/* @var $lista Array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Clientes';
$this->params['breadcrumbs'] = [
    ['label' => 'Clientes'],
  ];
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

<h1><?= Html::encode($this->title) ?></h1>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
    <?= Html::a('Nuevo Cliente',['create'], ['class' => 'btn btn-success']) ?>
</p>


<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'id' => 'cliente-grid',
      'rowOptions'=>function($model){
          if ($model["_estado"]=='X') {
            return ['class'=>'danger'];
          }
      },
      'columns' => [
      'placa',
      'nombre',
      'direccion',
      'telefono',
      '_registrado',
      [
        'attribute'=>'_estado',
        'value'=>function($model){
          switch ($model["_estado"]) {
            case 'A':
              return 'ACTIVO';
              break;
            case 'X':
            return 'INACTIVO';
            break;
            
            
          }
        }
      ],
          [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{update} {delete}',

              'buttons' => [
                'update' => function($url, $model, $key){
                  $url = ['update', 'id_cliente' => $model['id_cliente']];
                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app', 'Modificar Cliente'),
                    ]);
                },

                'delete' => function($url, $model, $key){
                  $url = ['delete', 'id_cliente' => $model['id_cliente']];
                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('app', 'Elmiminar Cliente'),
                    'data-confirm' => Yii::t('app', 'Desea eliminar el Cliente '.$model['nombre'].'?'),
                    ]);
                },
              ],
          ],
      ],
  ]); ?>