<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Activo */

$this->title = 'Crear Activo';
$this->params['breadcrumbs'][] = ['label' => 'Activos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
