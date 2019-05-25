<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Activo */

$this->title = 'Modificar Activo: ' . $model->id_activo;
$this->params['breadcrumbs'][] = ['label' => 'Activos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_activo, 'url' => ['view', 'id' => $model->id_activo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
