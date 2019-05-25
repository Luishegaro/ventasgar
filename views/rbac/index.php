<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DemoSearch */
/* @var $contratos array */

$this->title = 'Control de Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seguridad-index">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <? echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <? echo Yii::$app->session->getFlash('error'); ?>
        </div>
    <?php endif; ?>    

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Usuario', ['rbac/create-user'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="usuarios-list">    
        <?php 
          $dataProvider = new \yii\data\ArrayDataProvider([
              'allModels' => $usuarios,
              'key' => 'username',
              'pagination' => [
                  'pageSize'=> 12,
              ],
          ]);
        ?>

        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'id' => 'lista-grid',
          'columns' => [
              [
                'label' => 'Usuario',
                'attribute' => 'username',
              ],
              [
                'label' => 'Nombre',
                'attribute' => 'fullname',
              ],
              [
                'label' => 'Correo',
                'attribute' => 'email'
              ],
              [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {roles} {permisos}',
                'buttons' => [
                  'update' => function($url, $model, $key){
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 
                        ['rbac/update-user', 'id' => $key], 
                        ['title' => Yii::t('app', 'Modificar usuario')]);
                    },
                  'delete' => function($url, $model, $key){
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                        ['rbac/delete-user', 'id' => $key], 
                        ['
                          title' => Yii::t('app', 'Elmiinar usuario'),
                          'data-method' => 'post',
                          'data-confirm' => Yii::t('app','Desea eliminar el usuario?'),
                        ]);
                    },
                ],
              ],
          ],
        ]); ?>


    </div>    

</div>