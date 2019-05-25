<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $material Material */

$this->title = 'Modificar Material';
$this->params['breadcrumbs'] = [
  ['label' => 'Materiales', 'url' => ['admin-material/index']],  
  ['label' => 'Modificar material'],  
];
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="material-form">

  <?php $form = ActiveForm::begin(); ?> 

    <?= $form->errorSummary($material); ?>

    <?= $this->render('_form-general', ['model' => $material,'form' => $form,])?>


    

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['id'=>'subcli','class' => 'btn btn-primary', 'name' => 'material-button']) ?>
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