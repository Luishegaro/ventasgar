<?php

/* @var $this yii\web\View */
/* @var $patrimonio Patrimonio */


use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-12">
      <div class="col-md-6">
        <?= $form->field($model, 'nombre')->label('Nombre :');?>
      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'placa')->label('Placa :') ?>
      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'telefono')->label('Teléfono :')?> 
      </div>
      <div class="col-md-6"> 
        <?= $form->field($model, 'direccion')->label('Dirección :')?>
      </div>

      <div class="col-md-6">
      <?= $form->field($model, '_estado')->dropDownList([ 'A' => 'ACTIVO', 'X' => 'INACTIVO', ])->label('Estado :') ?>
      </div>
    </div>
    
    <div style="position: absolute;top: 0px;">
      <?= $form->field($model, 'id_cliente')->hiddenInput(['value' => $model->id_cliente])->label(false) ?>
    <?= $form->field($model, '_usuario')->hiddenInput(['value' => $model->_usuario])->label(false) ?>
    <?= $form->field($model, '_registrado')->hiddenInput(['value' => $model->_registrado])->label(false) ?>
    </div>
    
</div>


