<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\ClienteForm;

/* @var $this yii\web\View */
/* @var $model app\models\Adelanto */
/* @var $form yii\widgets\ActiveForm */
?>


<?= $form->field($model, 'id_pago')->hiddenInput(['value' => $model->id_pago])->label(false) ?>
<?= $form->field($model, '_usuario')->hiddenInput(['value' => $model->_usuario])->label(false) ?>
<?= $form->field($model, '_registrado')->hiddenInput(['value' => $model->_registrado])->label(false) ?>
<?= $form->field($model, 'tipo')->hiddenInput(['value' => 0])->label(false) ?>

<div class="row">
    

<div class="col-md-8">
    <?= $form->field($model, 'fecha')->widget(DatePicker::classname(), [
            'language' => 'es',
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'D,dd-mm-yyyy'
            ]])->label(false) ?>

        <?=$form->field($model, 'id_cliente')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(ClienteForm::getClientes(),'id_cliente','nombre'),
                    'options' => ['placeholder' => 'Selecciona un Cliente..'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents'=>[
                      "select2:select" => "function() {
                      $('#modalButton').text('Modificar Cliente');
                      $('#modalButton').attr('value', '".Url::to(['admin-cliente/update-ajax'])."&id_cliente='+$(this).val());
                    }",
                    "select2:unselecting" => "function() { 
                        $('#modalButton').text('Nuevo Cliente');
                        $('#modalButton').attr('value', '".Url::to(['admin-cliente/create-ajax'])."');
                    }",
                    ],
                    'addon' => [
                    'append' => [
                    'content' => Html::button('Nuevo Cliente', ['value'=>Url::to(['admin-cliente/create-ajax']),'class' => 'btn btn-primary', 'id'=>'modalButton']),
                      'asButton' => true]]
                    ])->label(false) ;?>
</div>
 </div>        

        <?= $form->field($model, 'concepto')->textarea(['rows' => '3',"placeholder"=>"Concepto"])->label(false) ?>
        <?= $form->field($model, 'monto')->textInput(['id'=>'intot',"placeholder"=>"Monto a cancelar"])->label('Ingreso Bs.')->label(false)  ?>





