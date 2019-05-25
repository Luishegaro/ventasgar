<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UrlManager;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $venta Venta */

$this->title = 'Nota de Entrega';
$this->params['breadcrumbs'] = [
  ['label' => 'Ventas', 'url' => ['admin-venta/lista']],  
  ['label' => 'Nota de Entrega'],  
];

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
<h1><?= Html::encode($this->title) ?></h1>


<div class="venta-form">

  <?php $form = ActiveForm::begin(); $url = \yii\helpers\Url::to(['admin-venta/deuda']); ?> 

    <?= $form->errorSummary($venta); ?>
    <div class="well">
      <div class="row">
          <div class="col-sm-8">
            <label>Los campos con (*) son requeridos.</label>
            <p>Para Agregar un Nuevo Cliente haga click en el boton "Nuevo Cliente".</p>
          
            <?=$form->field($venta, 'id_cliente')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map($clientes,'id_cliente','nombre'),
                  'options' => ['placeholder' => 'Selecciona un Cliente..'],
                  'pluginOptions' => [
                      'allowClear' => true,
                      
                  ],
                  'pluginEvents'=>["select2:select" => "function() {
                    $('#modalButton').text('Modificar Cliente');
                    $('#modalButton').attr('value', '".Url::to(['admin-cliente/update-ajax'])."?id_cliente='+$(this).val());
                      
                    $.ajax({
                    url: '".$url."',
                    type: 'GET',
                     data: { id: $('select').val() },
                     success: function(data) {
                        var data=$.parseJSON(data);
                        $('#inDeuda').val(data.deuda);
                        $('#btnFavor').text(data.favor);
                        $('#btnBuscar').attr('href', '".Url::to(['admin-venta/get-deuda'])."?id_cliente='+$('select').val());
                        $('#btnFavor').attr('href', '".Url::to(['admin-venta/get-saldo'])."?id_cliente='+$('select').val());
                     }
                 });
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
                <label class="control-label" >Deuda del Cliente seleccionado.</label> <br>
                <input type='text' id='inDeuda' disabled='true' value=''>
                <?= Html::a('Ver Detalle','javascript:void(0)', ['id'=>'btnBuscar','class'=>'btn btn-primary',]) ?>
                <label class="control-label" >Saldo a favor del Cliente seleccionado.</label><br>
                <a id="btnFavor" href="javascript:void(0)"  >0</a>
              </div>
              
          </div>
          
      
      </div>
    </div>
    

    <div class="row">
      <p>LLenar los datos de los materiales que desea vender al Cliente Seleccionado.<br>
      Puede llenar los datos de la <strong>cantidad</strong> y el <strong>precio unitario</strong> para calcular automaticamente los <strong>Subtotales</strong> y el <strong>Total</strong><br>
      Al ser necesario otros materiales aparte de los más usados que estan listados en la parte de abajo, puede hacer click en el botón <strong>"Mostrar más materiales"</strong> para ampliar la lista de abajo con los materiales restantes.<br>
      Para ocultarlos simplemente haga click nuevamente sobre el mismo boton.<br>
    </p>
      <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary " for="btnMostrar">
          <input id="btnMostrar" type="checkbox" autocomplete="off"> Mostrar más material
        </label>
      </div>
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

        <?php 
        $tamano=sizeof($materiales)/2;
        $cont=0;
        foreach ($materiales as $m) {
          $cont++;
          if ($tamano<=$cont) {
            echo "<tr class='ocultar'>";
          }
          else{
            echo "<tr>";
          }
          
          
          //echo  "<td class='col-md-1'>".$form->field($venta, 'cantidad')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1'><input type='number' id='txtMaterial".$m["id_material"]."' name='cantidad[".$m["id_material"]."]' class='sel' value=0 min='0' step=0.01 onchange='multi(this.value,".$m["id_material"].")'></td>";
          echo  "<td class='col-md-2' style='vertical-align:bottom'><p > ".$m["nombre"]."</p></td>";
          
          echo  "<td class='col-md-1' style='vertical-align:bottom'><input id='txtPrecio".$m["id_material"]."' value='".$m["precio"]."' class='sel' onchange='multi2(this.value,".$m["id_material"].")'></p></td>";
         
          //echo  "<td class='col-md-1'>".$form->field($venta, 'precio')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1'><input id='in".$m["id_material"]."' class='totalprice' type='number' name='precio[".$m["id_material"]."]' onchange='calcular()' step=0.01 value=0 min='0'></td>";
          echo "</tr>";


          } 
          echo "<tr class='active'><td class='col-md-2' style='vertical-align:center' colspan=3><p class='text-right'><strong>Total Bs.</strong></p></td><td class='col-md-1' style='vertical-align:center' > <input id='intot' type='number'  name='Venta[total]' step=0.01 value=0 readonly> </td></tr>";

          echo "<tr class='info'><td class='col-md-1' style='vertical-align:right'><p class='text-right'><label>Tipo de pago</label></p></td><td class='col-md-2' style='vertical-align:right' colspan=1>".$form->field($venta, 'tipo')->inline()->radioList($tipo,['id'=>'txtTipo','align'=>'right','value'=>0,])->label(false)."</td><td class='col-md-1'><p class='text-right'><strong>Cancelado Bs. *</strong></p></td><td class='col-md-1'><input id='incan' class='sel' type='number' name='Venta[cancelado]' step=0.01 value=0 min='0' readonly></td></tr>";

          /*echo "<tr class='danger'><td class='col-md-2' style='vertical-align:right' colspan=2><p class='text-right'> Tipo de cobro: ".Html::activeDropDownList($venta, 'tipo',$tipo,['id'=>'cbTipo','onchange'=>'cambiarTxt(this.value)'])."</p></td><td class='col-md-1'><p class='text-right'>CANCELADO Bs.</p></td><td class='col-md-1'><input id='incan' type='number' name='Venta[cancelado]' step=0.01 value=0 min='0' readonly></td></tr>";*/
          ?>
      </table>
      <p>Tipo de pago: Efectivo, cuando el cliente cancela en efectivo el total de la venta.</p>
      <p>Tipo de pago: Por Cobrar, cuando el cliente cancela una parte o nada de la venta, y se queda como deuda. (Al seleccionar esta opción se podra editar el campo "Cancelado" el monto de ingreso que dejó el cliente por la venta). <strong>Recuerda: Tiene que ser menor o igual que el campo "Total"</strong>.</p>
      <p>Tipo de pago: Retiro de material, cuando el cliente retira material que ya dejó pagando POR ADELANTADO.</p>
    </div>
    <div class="row">
      <?= $form->field($venta, '_usuario')->hiddenInput(['value' => $venta->_usuario])->label(false) ?>
      <?= $form->field($venta, '_registrado')->hiddenInput(['value' => $venta->_registrado])->label(false) ?>
      <?= $form->field($venta, 'observacion')->textarea(['rows' => '3']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['id'=>'subcli','class' => 'btn btn-primary', 'name' => 'venta-button',]) ?>
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
  var total=value*pre;
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
<?php
$script=<<< JS
$('.ocultar').hide();
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
$('#btnMostrar').change(function() {
    if($(this).is(":checked")) {
        $('.ocultar').show();
    }
    else
    {
      $('.ocultar').hide();
    }        
});
$(".sel").focus(function(){
       $(this).select();
    });
    $(".totalprice").focus(function(){
       $(this).select();
    });



    
JS;
$this->registerJs($script);
?>