<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProveedorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proveedor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_proveedor') ?>

    <?= $form->field($model, 'ci_nit') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'celular') ?>

    <?= $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, '_estado') ?>

    <?php // echo $form->field($model, '_registrado') ?>

    <?php // echo $form->field($model, '_usuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
