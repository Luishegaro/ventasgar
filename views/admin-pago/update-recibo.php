<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Adelanto */

$this->title = 'Modificar Recibo  Nro.: ' . $model->id_pago;
$this->params['breadcrumbs']=null; 
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-body">
            <div class="adelanto-update">
                <h3 class="text-center" style="margin-top: 0px"><?= Html::encode($this->title) ?></h3>
                <?php $form = ActiveForm::begin(); ?>
                <?= $this->render('_form-recibo', [
                    'model' => $model,
                    'form'=>$form,
                ]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Modificar', ['id'=>'subcli','class' => 'btn btn-primary', 'name' => 'cliente-button',]) ?>
                </div>
                <?php ActiveForm::end(); ?>
                <!-- sub clase -->
            </div>
        </div>
    </div>
</div>
