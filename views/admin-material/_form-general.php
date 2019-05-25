<?php

/* @var $this yii\web\View */
/* @var $model Material */


use yii\helpers\Url;
use yii\helpers\Html;

?>


<div class="row">
        <div class="col-lg-5">
        <?= $form->field($model, 'id_material')->hiddenInput(['value' => $model->id_material])->label(false) ?>
        <?= $form->field($model, '_usuario')->hiddenInput(['value' => $model->_usuario])->label(false) ?>
        <?= $form->field($model, '_registrado')->hiddenInput(['value' => $model->_registrado])->label(false) ?>
        <?= $form->field($model, 'nombre') ?>
        <?= $form->field($model, 'precio')->textInput(['type' => 'decimal']) ?>
        <?= $form->field($model, '_registrado')->textInput(['disabled' => true]) ?>
        <?= $form->field($model, '_usuario')->textInput(['disabled' => true]) ?>
          
          
        </div>
</div>


