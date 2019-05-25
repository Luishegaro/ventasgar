<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $cliente Cliente */

$this->title = 'Nuevo Cliente';
$this->params['breadcrumbs'] = [
  ['label' => 'Clientes', 'url' => ['admin-cliente/index']],  
  ['label' => 'Nuevo Cliente'],  
];
?>
<div class="cliente-form">
  <?php $form = ActiveForm::begin(['id'=>$cliente->formName(),
    'layout' => 'horizontal', 
    'enableAjaxValidation'=>true,
    'validationUrl'=>Url::toRoute('admin-cliente/validation')]); ?> 
    <?= $form->errorSummary($cliente); ?>
    <?= $this->render('_form-general', ['model' => $cliente,'form' => $form,])?>
    <div class="container-fluid text-right">
        <?= Html::submitButton('Adicionar Cliente', ['id'=>'subcli','class' => 'btn btn-primary', 'name' => 'cliente-button',]) ?>
    </div>
  <?php ActiveForm::end(); ?>
  <?php
  $script=<<<JS
    $('form').submit(function(){
    $(this).find('button[type!="button"],input[type="submit"]').attr("disabled",true);
    setTimeout(function(){
        $('form .has-error').each(function(index, element) {
            $(this).parents("form:first").find(":submit").removeAttr("disabled");
        });
    },1000);
});
JS;
$this->registerJs($script);
  ?>
</div>