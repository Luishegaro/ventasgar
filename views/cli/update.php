<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cli */

$this->title = 'Update Cli: ' . $model->id_cliente;
$this->params['breadcrumbs'][] = ['label' => 'Clis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_cliente, 'url' => ['view', 'id' => $model->id_cliente]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cli-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
