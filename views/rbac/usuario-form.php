
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model User */


$this->title = $accion.' Usuario';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="usuario-form">

  <?php $form = ActiveForm::begin(); ?> 
    <?=$form->field($model, 'rol')->inline()->radioList(['VENTAS'=>'VENTAS','ADMIN'=>'ADMINISTRADOR'],['value'=>'VENTAS',])->label(false)?>
    <?= $form->field($model, 'fullname'); ?>
    <?= $form->field($model, 'email'); ?>
    <?= $form->field($model, 'username'); ?>
    <?= $form->field($model, 'password'); ?>

    <?= $form->field($model, 'id')->hiddenInput(['value' => $model->username])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary', 'name' => 'contrato-button']) ?>
    </div>
  <?php ActiveForm::end(); ?>

</div>