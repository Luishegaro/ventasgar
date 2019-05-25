<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activo-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),'enableAjaxValidation'=>true,
  'validationUrl'=>Url::toRoute('activo/validation')]); ?>

    <?= $form->field($model, 'codigo')->textInput(['id'=>'txtNombre','maxlength' => true]) ?>

    <?= $form->field($model, 'detalle')->textInput(['id'=>'txtModelo','maxlength' => true]) ?>

    <?= $form->field($model, 'cuenta')->radioList(['MAQUINARIA GENERAL'=>'Maquinaria General','EQUIPO PESADO'=>'Equipo Pesado','HERRAMIENTAS'=>'Herramientas','VEHICULO'=>'Vehiculo'],['id'=>'txtTipo'])->label("Cuenta") ?>

    <?= $form->field($model, '_registrado')->hiddenInput()->label(false) ?>

    <?= $form->field($model, '_usuario')->hiddenInput()->label(false) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
