<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CliSearch */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="row">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <div class="col-xs-6 col-md-4">
            <?= $form->field($model, 'nombre')->textInput(["placeholder"=>"NOMBRE"])->label(false) ?>
        </div>
        <div class="col-xs-6 col-md-2"><?= $form->field($model, 'numero')->textInput(["placeholder"=>"NUMERO DE RECIBO"])->label(false) ?></div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary','style'=>'margin-right:10px;']) ?>
                <?= Html::resetButton('Actualizar', ['class' => 'btn btn-default','style'=>'margin-right:10px;']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-print"></span> Vista Impresión','#', ['id'=>'btnImprimir','onclick'=>'printData()','class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="col-md-12"><hr></div>
    </div>

