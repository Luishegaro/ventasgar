<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Activo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'codigo',
            'detalle',
            'cuenta',
            [
                'attribute'=>'_registrado',
                'filter'=>false
            ],
            [
                'attribute'=>'_usuario',
                'filter'=>false
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
