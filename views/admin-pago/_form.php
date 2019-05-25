<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;
use kartik\date\DatePicker;
use app\models\PagoForm;
use app\models\ClienteForm;


/* @var $this yii\web\View */
/* @var $model app\models\PagoForm */
/* @var $vemta app\models\ReciboForm */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="row">
  <div class="col-md-offset-1 col-md-5">
    <div class="panel panel-default">
    <div class="panel-body">
      <h4 class="text-center">Número de Venta <br> <?=  $venta->id_venta ?></h4>
      <label><strong>Fecha : </strong><?=  $venta->fecha ?></label><br>
      <label><strong>Placa : </strong><?=  ClienteForm::getById($venta["id_cliente"])->placa ?></label><br>
      <label><strong>Cliente : </strong><?=  ClienteForm::getById($venta["id_cliente"])->nombre ?></label><br>
      <label><strong>Total Bs. Venta : </strong><?=  $venta->total ?></label><br>
      <label><strong>Total Bs. que se ha pagado : </strong><?=  $venta->cancelado+PagoForm::getTotalPagado($venta["id_venta"]) ?></label><br>
      <label><strong>Total Bs. que falta : </strong><?=  $venta->saldo ?></label>
      <!--
      	<?= DetailView::widget([
              'model' => $venta,
              'attributes' => [
                [
                	'attribute'=>'id_venta',
                	'label'=>'Numero de Venta',
                ],
                [
                  'attribute'=>'fecha',
                  'format'=> ['date', 'php:D, d/m/Y']
                ],
                [
                  'attribute'=>'id_venta',
                  'label'=>'Placa',
                  'value'=>function($model){
                    return ClienteForm::getById($model["id_cliente"])->placa;
                  },
                ],
                [
                  'attribute'=>'id_venta',
                  'label'=>'Cliente',
                  'value'=>function($model){
                    return ClienteForm::getById($model["id_cliente"])->nombre;
                  },
                ],
                [
                	'attribute'=>'total',
                	'label'=>'Total de Bs. de la Venta',
                ],
                [
                	'label'=>'Total de Bs. que ya se han pagado',
                  'value'=>function($model){
                    return $model->cancelado+PagoForm::getTotalPagado($model["id_venta"]);
                  },
                ],
                [
                	'attribute'=>'saldo',
                	'label'=>'Total de Bs. que aún faltan',
                ],
              ],
            ]); ?> -->
          </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="panel panel-default">
        <h4 class="text-center">Datos Recibo</h4>
          <div class="panel-body">
            
              <?php $form = ActiveForm::begin(); ?>
              <?= $form->field($model, 'fecha')->widget(DatePicker::classname(), [
                'language' => 'es',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'D,dd-mm-yyyy'
                ]]) ?>
               <?= Html::hiddenInput('saldo', $venta["saldo"]); ?>
               <?= $form->field($model, 'id_venta')->hiddenInput(['value' => $venta["id_venta"]])->label(false) ?>
               <?= $form->field($model, 'concepto')->hiddenInput(['value' =>'Por cobro de deuda de la venta Nro.'.$venta["id_venta"]." <strong><u>( N.E.-".$venta["numero"]." )</u></strong>"])->label(false) ?>
               <?= $form->field($model, 'id_cliente')->hiddenInput(['value' => $venta["id_cliente"]])->label(false) ?>
               <?= $form->field($model, '_registrado')->hiddenInput(['value' => $model->_registrado])->label(false) ?>
              <?= $form->field($model, 'monto')->textInput(['id'=>'txtmonto','type'=>'number','min'=>0,'max'=>$venta["saldo"], 'step'=>0.1]) ?>
              <?= $form->field($model, '_usuario')->hiddenInput(['value' => $model->_usuario])->label(false) ?>
                <?= $form->field($model, '_registrado')->hiddenInput(['value' => $model->_registrado])->label(false) ?>

          <div class="form-group">
              <?= Html::submitButton('Guardar', ['id'=>'subcli','class' => 'btn btn-primary', 'name' => 'pago-button',]) ?>
          </div>

          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
 </div>


