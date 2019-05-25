<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UrlManager;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $venta Venta */

$this->title = 'MODIFICAR NOTA DE ENTREGA';
$this->params['breadcrumbs'] = null;

?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif; ?>
<div class="panel panel-primary">
    <div class="panel-heading text-center">
      <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
      <div class="venta-form">
  <label>Los campos con (*) son requeridos.</label>
  <?php $form = ActiveForm::begin(); $url = \yii\helpers\Url::to(['admin-venta/deuda']); ?> 
    <?= $form->errorSummary($venta); ?>
    <div class="well">
      <div class="row">
          <div class="col-lg-5">
            <?=$form->field($venta, 'id_cliente')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map($clientes,'id_cliente','nombre'),
                  'options' => ['placeholder' => 'Selecciona un Cliente..'],
                  'pluginOptions' => [
                      'allowClear' => true,
                    ],
                  ])->label("Seleccione el Cliente que desee añadir a la nota de venta. *");?>
            <?= $form->field($venta, 'fecha')->widget(DatePicker::classname(), [
              'language' => 'es',
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'dd-mm-yyyy'
              ]])->label("Seleccione la fecha de la nota de venta. *") ?>
              </div>
              <div class="col-sm-4">
                <?= $form->field($venta, 'numero')->textInput()->label("Numero de nota de venta Fisica") ?>
              </div>
          </div>
      </div>
    </div>
    <p>LLenar los datos de los materiales que desea vender al Cliente Seleccionado.<br>
      Puede llenar los datos de la <strong>cantidad</strong> y el <strong>precio unitario</strong> para calcular automaticamente los <strong>Subtotales</strong> y el <strong>Total</strong><br>
    </p>

    <div class="row">
      <table class="table table-hover">
        <tr>
          <th>
            <label class="control-label" >CANT.</label>
          </th>
          <th>
            <label class="control-label" >DETALLE</label>
          </th>
          <th>
            <label class="control-label" >P. UNIT. (Bs)</label>
          </th>
          <th>
            <label class="control-label" >P. TOTAL (Bs)</label>
          </th>
        </tr> 
        <?php $cont=0;
        foreach ($materiales as $m) {

          echo "<tr>";
          //echo  "<td class='col-md-1'>".$form->field($venta, 'cantidad')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1'><input type='number' id='txtMaterial".$m["id_material"]."' name='cantidad[".$m["id_material"]."]' value=". number_format((float)$m["cantidad"], 2, '.', '')." min='0' step=0.01 onchange='multi(this.value,".$m["id_material"].")'></td>";
          echo  "<td class='col-md-2' style='vertical-align:bottom'><p > ".$m["nombre"]."</p></td>";
          
          echo  "<td class='col-md-1' style='vertical-align:bottom'><p><input id='txtPrecio".$m["id_material"]."' type='number' onchange='multi2(this.value,".$m["id_material"].")' value=". number_format((float)$m["precio"], 2, '.', '')." step=0.01></p></td>";
         
          //echo  "<td class='col-md-1'>".$form->field($venta, 'precio')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1'><input id='in".$m["id_material"]."' class='totalprice' type='number' name='precio[".$m["id_material"]."]' onchange='calcular()' step=0.01 value=".$m["costo"]." min='0'></td>";
          echo "</tr>";
          } 
          echo "<tr class='info'><td class='col-md-2' style='vertical-align:center' colspan=3><p class='text-right'>TOTAL Bs.</p></td><td class='col-md-1' style='vertical-align:center' > <input id='intot' type='number' name='Venta[total]' step=0.01 value=0 readonly> </td></tr>";

          echo "<tr class='danger'><td class='col-md-2' style='vertical-align:right' colspan=2>".$form->field($venta, 'tipo')->inline()->radioList($tipo,['id'=>'txtTipo','align'=>'right'])->label(false)."</td><td class='col-md-1'><p class='text-right'>CANCELADO Bs.</p></td><td class='col-md-1'><input id='incan' type='number' name='Venta[cancelado]' step=0.01 value=".$venta["cancelado"]." min='0'";

          if ($venta["tipo"]==1) {
            echo "></td></tr>";
          }
          else{
            echo "readonly></td></tr>";
          }

          /*echo "<tr class='danger'><td class='col-md-2' style='vertical-align:right' colspan=2><p class='text-right'> Tipo de cobro ".Html::activeDropDownList($venta, 'tipo',$tipo,['id'=>'cbTipo','onchange'=>'cambiarTxt(this.value)'])."</p></td><td class='col-md-1'><p class='text-right'>CANCELADO Bs.</p></td><td class='col-md-1'> <input id='incan' type='number' name='Venta[cancelado]' step=0.01 value=".$venta["cancelado"]." min='0'  readonly></td></tr>";*/
          ?>
      </table>
    </div>
    <div class="row">
      <div class="col-lg-5">
        <?= $form->field($venta, 'id_venta')->hiddenInput(['value' => $venta->id_venta])->label(false) ?>
        <?= $form->field($venta, '_usuario')->hiddenInput(['value' => $venta->_usuario])->label(false) ?>
        <?= $form->field($venta, '_registrado')->hiddenInput(['value' => $venta->_registrado])->label(false) ?>
        <?= $form->field($venta, 'observacion')->textarea(['rows' => '3']) ?>
        <?= $form->field($venta, '_registrado')->textInput(['disabled' => true]) ?>
        <?= $form->field($venta, '_usuario')->textInput(['disabled' => true]) ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['id'=>'subcli','class' => 'btn btn-primary', 'name' => 'venta-button',]) ?>
    </div>
    </div>
  </div>  
  <?php ActiveForm::end(); ?>
<script>

var suma=0;

function multi2(value,id) {
  var mat=document.getElementById("txtMaterial"+id).value;
  var total=value*mat;
  document.getElementById("in"+id).value=total.toFixed(2);

  var sum = 0;
  $('.totalprice').each(function(){
      sum += parseFloat(this.value);
  });
  document.getElementById("intot").value=sum.toFixed(2);
  document.getElementById("incan").value=sum.toFixed(2);
  valid(sum.toFixed(2));
}

function multi(value,id) {
  var pre=document.getElementById("txtPrecio"+id).value;
  var total=parseFloat(value)*parseFloat(pre);
  document.getElementById("in"+id).value=total.toFixed(2);
  var sum = 0;
  $('.totalprice').each(function(){
      sum += parseFloat(this.value);
  });
  document.getElementById("intot").value=sum.toFixed(2);
  document.getElementById("incan").value=sum.toFixed(2);
  valid(sum.toFixed(2));
}

function calcular()
{
  var sum = 0;
  $('.totalprice').each(function(){
      sum += parseFloat(this.value);
  });
  document.getElementById("intot").value=sum.toFixed(2);
  document.getElementById("incan").value=sum.toFixed(2);
  valid(sum.toFixed(2));
}
function calculartotal()
{
  var sum = 0;
  $('.totalprice').each(function(){
      sum += parseFloat(this.value);
  });
  document.getElementById("intot").value=sum.toFixed(2);
  valid(sum.toFixed(2));
}
function valid(value)
{
  $("#incan").attr({
       "max" : value,        // substitute your own
       "min" : 0          // values (or variables) here
    });
}

</script>
</div>
<?php $script = <<< JS
$(document).ready(function(){
   calculartotal();
   $("#txtTipo").on("change","input[type=radio]",function(){
    var value=$('[name="Venta[tipo]"]:checked').val();
    if (value==0) {
      calcular();
      $("#incan").prop('readonly', true); 
    }
    if (value==1) {
      $("#incan").prop('readonly', false);

    }
    if (value==2) {
      $("#incan").val(0);
      $("#incan").prop('readonly', true);
    }
});
}); 
JS;
$this->registerJs($script, View::POS_END);?>