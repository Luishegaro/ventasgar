<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Adelanto */

$this->title = 'Crear Recibo';
$this->params['breadcrumbs']=null; 
?>
  <div class="row">
    <div class="col-md-6 col-md-offset-3" style="margin-top: 10px;">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="adelanto-create">
            <h3 class="text-center" style="margin-top: 0px"><?= Html::encode($this->title) ?></h3>
                <?php $form = ActiveForm::begin(); ?>
                  <?= $this->render('_form-recibo', [
                      'model' => $model,
                      'form'=>$form,                     
                  ]) ?>
                  <div class="form-group">
                        <?= Html::submitButton('Guardar', ['id'=>'subcli','class' => 'btn btn-success', 'name' => 'cliente-button',]) ?>
                    </div>
              <?php ActiveForm::end(); ?>
            <?php 
              Modal::begin([
                  'header'=>'<h4>Datos Cliente</h4>',
                  'id'=>'modal',
                  'size'=>'modal-lg',
                ]);
              echo "<div id='modalContent'></div>";
              Modal::end();
            ?>
        </div>
      </div>
    </div>
  </div>
</div>

