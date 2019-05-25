<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CliSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row cli-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="colxs-12 col-md-2">
        <?= $form->field($model, 'placa') ?>
    </div>
    <div class="col-xs-12 col-md-4">
        <?= $form->field($model, 'nombre') ?>
    </div>
    

    

    

    <div class="col-md-6">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Actualizar', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-md-12">
        <hr >
    </div>
</div>
