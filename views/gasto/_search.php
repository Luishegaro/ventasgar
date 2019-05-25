<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdelantoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
     
          <div class="col-xs-12 col-md-4">
              <?= $form->field($model, 'nombre')->textInput(["placeholder"=>"NOMBRE"])->label(false) ?>
          </div>
          <div class="col-xs-6 col-md-2">
              <?= $form->field($model, 'numero')->textInput(["placeholder"=>"NUMERO"])->label(false) ?>
          </div>
          <div class="col-xs-6 col-md-2">
              <?= $form->field($model, '_estado')->dropDownList([ 'A' => 'Activa', 'X' => 'Anulada',''=>'Mostrar Todos'])->label(false) ?>
          </div>
          <div class="form-group col-md-4">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary','style'=>'margin-right:10px;']) ?>
            <?= Html::resetButton('Actualizar', ['class' => 'btn btn-default','style'=>'margin-right:10px;']) ?>
            <?= Html::a('Crear Gasto', ['create'], ['class' => 'btn btn-success']) ?>
          </div>            
     
    <?php ActiveForm::end(); ?>
    <div class="col-md-12">
      <hr style="margin-top: 0px;border-top: 1px solid #038cec">
    </div>
</div>

