<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Cli */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cli-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,
    'validationUrl'=>Url::toRoute('cli/validation')]); ?>

    <?= $form->field($model, 'placa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deuda')->textInput() ?>

    <?= $form->field($model, '_registrado')->textInput() ?>

    <?= $form->field($model, '_usuario')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
