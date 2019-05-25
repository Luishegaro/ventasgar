<?php

/* @var $this yii\web\View */
/* @var $lista Array */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Materiales';
$this->params['breadcrumbs'] = [
    ['label' => 'Materiales'],
  ];
?>


<?php 
    $dataProvider = new \yii\data\ArrayDataProvider([
        'allModels' => $lista,
        'key' => 'id_material',
        'pagination' => [
            'pageSize'=> 12,
        ],
    ]);
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

<p>
    <?= Html::a('Nuevo Material',['create'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
      'dataProvider' => $dataProvider,
      'id' => 'material-grid',
      'columns' => [
      'nombre',
      'precio',
      
          [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{update} {delete}',

              'buttons' => ['update' => function($url, $model, $key){
                  $url = ['update', 'id_material' => $model['id_material']];
                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('app', 'Modificar Material'),
                    ]);
                },

                'delete' => function($url, $model, $key){
                  $url = ['delete', 'id_material' => $model['id_material']];
                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('app', 'Elmiminar Material'),
                    'data-confirm' => Yii::t('app', 'Desea eliminar el Material '.$model['nombre'].'?'),
                    ]);
                },
              ],
          ],
      ],
  ]); ?>