<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cli */

$this->title = $model->id_cliente;
$this->params['breadcrumbs'][] = ['label' => 'Clis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cli-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_cliente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_cliente], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_cliente',
            'placa',
            'nombre',
            'telefono',
            'direccion',
            'deuda',
            '_registrado',
            '_usuario',
        ],
    ]) ?>

</div>
