<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\CliSearch */
/* @var $form yii\widgets\ActiveForm */
?>

        <div class="row">

    <?php $form = ActiveForm::begin([
        'action' => ['lista'],
        'method' => 'get',
    ]); ?>
    <div class="col-xs-12 col-md-4">
        <?= $form->field($model, 'nombre')->textInput(["placeholder"=>"NOMBRE CLIENTE"])->label(false) ?>
    </div>
    <div class="col-xs-12 col-md-4">
        <?php
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'fecha_inicio',
                'attribute2' => 'fecha_fin',
                'options' => ['placeholder' => 'FECHA INICIO'],
                'options2' => ['placeholder' => 'FECHA FIN'],
                'type' => DatePicker::TYPE_RANGE,
                'form' => $form,
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'autoclose' => true,
                ]
            ]);
        ?>
        <br>
    </div>
    <div class="col-xs-6 col-md-2">
        <?= $form->field($model, 'numero')->textInput(["placeholder"=>"NUMERO"])->label(false) ?>
    </div>
    
    <div class="col-xs-6 col-md-2">
        <?= $form->field($model, '_estado')->dropDownList([ 'A' => 'Activa', 'X' => 'Anulada',''=>'Mostrar Todos'])->label(false) ?>
    </div>
    <div class="col-xs-12 col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary','style'=>'margin-right:10px;']) ?>
            <?= Html::resetButton('Actualizar', ['class' => 'btn btn-default','style'=>'margin-right:10px;']) ?>
            <?= Html::a('Nueva Venta',['principal'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    

    <?php ActiveForm::end(); ?>
    <div class="col-md-12"><hr style="margin-top: 0px"></div>
  </div>

