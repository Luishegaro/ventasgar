<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Proveedor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proveedor-form">
<div class="panel panel-default">
    <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ci_nit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, '_usuario')->hiddenInput(['value' => $model->_usuario])->label(false) ?>
<?= $form->field($model, '_registrado')->hiddenInput(['value' => $model->_registrado])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>


</div>
