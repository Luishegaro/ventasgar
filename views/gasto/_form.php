<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\Proveedor;
use app\models\Activo;

/* @var $this yii\web\View */
/* @var $model app\models\Adelanto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel-group">
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-body">
        <?= $form->field($model, 'fecha')->widget(DatePicker::classname(), [
        'language' => 'es',
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]])->label(false) ?>
  
    <div class="row">
      <div class="col-md-8">
        <?= $form->field($model, 'pagado_a')->textInput(['id'=>'txtPagado','placeholder' => 'Pagado a : (Seleccione un proveedor en la parte de abajo)'])->label(false) ?>
      </div>
      <div class="col-md-4">
        <?= Html::a('Adicionar Proveedor', ['proveedor/create','action'=>'1'], ['class' => 'btn btn-primary btn-block']) ?> 
      </div>
    </div>
        <?= Html::dropDownList('category', null, ArrayHelper::map(Proveedor::find()->orderBy('nombre')->all(), 'nombre', 'nombre'), [
             'multiple' => 'multiple',
             'class'=>'form-control',
             'onchange'=>'sel(this.value)'
          ]) ?>
          <br>

          <?= $form->field($model, 'concepto')->textarea(['rows' => '2','placeholder' => 'Por concepto..'])->label(false)?>
          <?= $form->field($model, 'monto')->textInput(['id'=>'intot','placeholder' => 'Egreso Bs.'])->label(false) ?>    
      </div>
  </div>
</div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <?= $form->field($model, 'nro_factura')->textInput(['placeholder' => 'Nro. factura'])->label(false) ?>



       <!-- <?= $form->field($model, 'tipo')->radioList(['FUNCIONAMIENTO'=>'Funcionamiento','MANTENIMIENTO'=>'Mantenimiento','REPARACION'=>'Reparacion','OTROS'=>'Otros'],['id'=>'txtTipo'])->label("Tipo de Gasto") ?>-->

      
        <?= $form->field($model, 'tipo')->inline()->radioList(['FUNCIONAMIENTO'=>'Funcionamiento','MANTENIMIENTO'=>'Mantenimiento','REPARACION'=>'Reparacion','OTROS'=>'Otros'],['id'=>'txtTipo','class'=>'row btn-group col-md-12','item' => function($index, $label, $name, $checked, $value) {
                            if ($checked) {
                              $return = '<label class="btn btn-default col-sm-12 col-md-3">';
                              $return .= '<input type="radio"  name="' . $name . '" value="' . $value . '" checked>';
                            }else{

                              $return = '<label class="btn btn-default col-sm-12 col-md-3">';
                              $return .= '<input type="radio"  name="' . $name . '" value="' . $value . '">';
                            }
                            $return .= ucwords($label) ;
                            $return .= '</label>';
                            return $return;
                        }])->label("Tipo de Gasto")?>




        <?=$form->field($model, 'id_activo')->widget(Select2::classname(), [
              'data' =>  [
                'EQUIPO PESADO'=>ArrayHelper::map(Activo::find()->where(['cuenta' =>'EQUIPO PESADO' ])->orderBy('detalle')->all(), 'id_activo', 'detalle'),
              'VEHICULO'=>ArrayHelper::map(Activo::find()->where(['cuenta' =>'VEHICULO' ])->orderBy('detalle')->all(), 'id_activo', 'detalle'),
              'MAQUINARIA GENERAL'=>ArrayHelper::map(Activo::find()->where(['cuenta' =>'MAQUINARIA GENERAL' ])->orderBy('detalle')->all(), 'id_activo', 'detalle'),
              'HERRAMIENTAS'=>ArrayHelper::map(Activo::find()->where(['cuenta' =>'HERRAMIENTAS' ])->orderBy('detalle')->all(), 'id_activo', 'detalle')],//ArrayHelper::map(Activo::find()->orderBy('detalle')->all(), 'id_activo', 'detalle'),
              'options' => ['id'=>'txtActivo','disabled'=>$activo,'placeholder' => 'Selecciona un Activo..'],
              'pluginOptions' => [
                  'allowClear' => true,
              ],
              'pluginEvents'=>["select2:select" => "function() {
                $('#modalButton').text('Modificar Activo');
                $('#modalButton').attr('value', '".Url::to(['activo/update-ajax'])."?id='+$(this).val());
                 }",
             "select2:unselecting" => "function() { 
                $('#modalButton').text('Nuevo Activo');
                $('#modalButton').attr('value', '".Url::to(['activo/create-ajax'])."');
            }",
               ],
        'addon' => [
        'append' => [
        'content' => Html::button('Nuevo Activo', ['value'=>Url::to(['activo/create-ajax']),'class' => 'btn btn-primary', 'id'=>'modalButton']),
          'asButton' => true]]
          ])->label(false);?>
          <?= $form->field($model, 'observacion')->textarea(['rows' => '2','placeholder' => 'Observaciones'])->label(false) ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $form->field($model, 'id_activo')->hiddenInput(['value'=>""])->label(false) ?>

<?= $form->field($model, 'id_gasto')->hiddenInput(['value' => $model->id_gasto])->label(false) ?>
<?= $form->field($model, '_usuario')->hiddenInput(['value' => $model->_usuario])->label(false) ?>
<?= $form->field($model, '_registrado')->hiddenInput(['value' => $model->_registrado])->label(false) ?>
<script type="text/javascript">
  var rad = document.getElementsByName('Gasto[tipo]');
  var activo = document.getElementById('txtActivo');
    var prev = null;
    for(var i = 0; i < rad.length; i++) {
        rad[i].onclick = function() {
            if (this.value=='OTROS') {
              activo.disabled=true;
            }
            else
            {
              activo.disabled=false;
            }
        };
    }
  function sel(item) {
    var pagado=document.getElementById('txtPagado');
    pagado.value=item;
  }
</script>
<?php
$script=<<< JS

JS;
$this->registerJs($script);
?>

