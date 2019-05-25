<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Adelanto */

$this->title = 'MODIFICAR RECIBO DE GASTO : ' . $model->id_gasto;
$this->params['breadcrumbs']=null;
?>
<div class="adelanto-update">
  <h3 class="text-center"> <?= Html::encode($this->title) ?> </h3>
      <?php $form = ActiveForm::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'form'=>$form,
        'activo'=>$activo,
    ]) ?>
    <div class="form-group text-right">
        <?= Html::submitButton('Guardar cambios', ['id'=>'subcli','class' => 'btn btn-primary', 'name' => 'cliente-button',]) ?>
     </div>
     <?php ActiveForm::end(); ?>
     <?php 
      Modal::begin([
          'header'=>'<h4>Datos Activo</h4>',
          'id'=>'modal',
          'size'=>'modal-lg',
        ]);
      echo "<div id='modalContent'></div>";
      Modal::end();
    ?>
</div>
