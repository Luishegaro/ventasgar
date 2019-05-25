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
/* @var $venta Venta   #2a7bc3*/ 

$this->title = 'NOTA DE ENTREGA';
$this->params['breadcrumbs'] = null;
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div id="alerta" class="alert alert-success">
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div id="alerta" class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif; ?>
<style type="text/css" media="screen">
  td{vertical-align: middle;}
</style>
  <?php $form = ActiveForm::begin(); $url = \yii\helpers\Url::to(['admin-venta/deuda']); ?>
  <div class="panel-group">
      <div class="panel panel-default" style="margin-top: 10px">
        <!--<div class="panel-heading text-center">NOTA DE ENTREGA</div>-->
      <div class="panel-body" style="padding-bottom: 0px">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-3">
            <input type="hidden" id="txtCliente" value="">
              <?=$form->field($venta, 'id_cliente')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map($clientes,'id_cliente','nombre'),
                                'options' => ['placeholder' => 'NOMBRE CLIENTE'],
                                'pluginOptions' => [
                                    'allowClear' => false,
                                ],
                                'pluginEvents'=>["select2:select" => "function() {
                                  $('#txtCliente').val($('#select2-venta-id_cliente-container').text());
                                  $('#modalButton').text('Modificar Cliente');
                                  $('#modalButton').attr('value', '".Url::to(['admin-cliente/update-ajax'])."?id_cliente='+$(this).val());
                                    
                                  $.ajax({
                                  url: '".$url."',
                                  type: 'GET',
                                   data: { id: $('select').val() },
                                   success: function(data) {
                                      var data=$.parseJSON(data);
                                      $('#btnBuscar').text('DEUDA :'+data.deuda);
                                      $('#btnFavor').text('SALDO :'+data.favor);
                                      
                                      $('#btnArena').text('Arena :'+data[1]);

                                      $('#btnGrava').text('Grava..3/4 :'+data[3]);

                                      $('#btnBuscar').val('".Url::to(['admin-venta/get-deuda'])."?id_cliente='+$('select').val());
                                      $('#btnFavor').val('".Url::to(['admin-venta/get-saldo'])."?id_cliente='+$('select').val());
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
                            ])->label(false);?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                          <?= $form->field($venta, 'fecha')->widget(DatePicker::classname(), [
                                  'language' => 'es',
                                  'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                  'pluginOptions' => [
                                      'autoclose'=>true,
                                      'format' => 'DD,dd-mm-yyyy'
                                  ]])->label("Fecha *")->label(false) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3" style="margin-bottom: 15px;">
              <?= Html::button('DEUDA : 00', ['id'=>'btnBuscar','value'=>'','class'=>'btn btn-default active','style'=>'margin-right:10px;width:45%']) ?>
              <?= Html::button('SALDO : 00', ['id'=>'btnFavor','value'=>'','class'=>'btn btn-default active','style'=>'width:45%']) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3" style="margin-bottom: 15px;">
              <button type="button" id="btnArena" class="btn btn-success" disabled="disabled" style="margin-right: 10px;width: 45%">Arena : 00</button>
              <button type="button" id="btnGrava" class="btn btn-danger" disabled="disabled" style="width: 45%">Grava..3/4 : 00</button>
            </div>
          </div>
        </div>
      </div>
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6" style="margin-top: 10px;">
      <div class="panel panel-default">
        <div class="panel-body" style="overflow-x: scroll;">
          <?= $form->field($venta, 'materiales')->hiddenInput(["id"=>"txtMateriales"])->label(false) ?>
          <div class="table-responsive pre-scrollable" style="margin-top:-15px;padding-bottom:80px; border: 1px solid #ddd;height: 210pt">
            <table id="tbDetalle" class="table">
              <tr style="background-color: #f1efef">
                <th>CANT.</th>
                <th>MATERIAL</th>
                <th>P. UNIT.</th>
                <th>P. TOTAL</th>
                <th></th>
              </tr>
            </table>
          </div>
         <div class="col-md-12" style="padding-left: 0px;">
            <table  class="table" style="position:absolute; bottom:0px;">
                <tbody>
                  <tr style="background-color: #f1efef">
                  <th colspan="3" class="text-right">TOTAL :</th>
                  <th>
                   <input id="txtTotal" type="number" name='Venta[total]' step="0.01" style="width: 90px;padding-left:10px;font-size: 11pt;border: none" readonly="" value=0>
                  </th>
                  <th style="border-top: none;" rowspan="2">
                    <?= Html::submitButton('GUARDAR', ['id'=>'subcli','class' => 'btn btn-danger btn-block','name' => 'venta-button','style'=>'padding-top:25px;padding-bottom:25px;']) ?>
                  </th>
                </tr>
                <tr style="background-color: #f1efef">
                  <th colspan="2" style="border-top: none;">
                    <?= $form->field($venta, 'tipo')->inline()->radioList($tipo,['id'=>'txtTipo','class'=>'btn-group col-md-12','data-toggle'=>'buttons','align'=>'right','value'=>0,'item' => function($index, $label, $name, $checked, $value) {
                          if ($value==0) {
                            $return = '<label class="btn btn-default active col-sm-12 col-md-4">';
                            $return .= '<input type="radio"  name="' . $name . '" value="' . $value . '" checked>';
                          }
                          else
                          {
                            $return = '<label class="btn btn-default col-sm-12 col-md-4">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '">';
                          }
                            $return .= ucwords($label) ;
                            $return .= '</label>';

                            return $return;
                        }])->label(false)?>
                  </th>
                  <th class="text-right" style="border-top: none;">CANCELADO :</th>
                  <th style="border-top: none;">
                    <input id="incan" class="sel" type="number" name='Venta[cancelado]' step="0.01" style="width: 90px;padding-left:10px;font-size: 13pt" onclick="setValor(this)" value=0 readonly>
                  </th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6" style="margin-top: 10px"> 
      <div class="panel panel-default">
        <div class="panel-body">
            <div class="row pre-scrollable" style="height: 183pt">
              <?php foreach ($materiales as $m):?>
              <div class="col-xs-6 col-sm-4 col-md-3" style="margin-bottom: 25px;">
                <a id="btn-<?=$m["id_material"]?>" class="btn btn-squared-default-plain btn-default" onclick="addProducto(<?= $m["id_material"] ?>,<?= "'".str_replace('"','',$m["nombre"]) ."'" ?>,<?= $m["precio"] ?>)" style="padding: 0px">
                    <i><img src="../img/<?= $m["id_material"] ?>.jpg"  class="img-responsive img-rounded" width="100%"></i>
                    <span class="imagebox-desc text-warning" style="font-size:12pt;"><b><?= $m["nombre"] ?></b></span>
                </a>
              </div>
            <?php endforeach ?>
          </div>
            <div class="btn-group text-center" style="width: 100%">
              <input id="txtCantidad" style="width: 100%;height:28px;font-size: 28pt;margin-top: 10px;border-color: #66afe9" class="form-control" value=""  placeholder="CANTIDAD" type="number">
              <span id="searchclear" class="glyphicon glyphicon-remove-circle"></span>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default" style="margin-top: 10px">    
        <div class="panel-body">
          <?= $form->field($venta, '_usuario')->hiddenInput(['value' => $venta->_usuario])->label(false) ?>
          <?= $form->field($venta, '_registrado')->hiddenInput(['value' => $venta->_registrado])->label(false) ?>
          <input type="hidden" id="txtId" value="<?= date_timestamp_get(date_create($venta->_registrado)) ?>">
          <?= $form->field($venta, 'observacion')->textarea(['id'=>'txtObservacion','rows' => '3','onclick'=>'getId(this)']) ?>
      </div>
    </div>
   </div>
  </div>
</div>
  <?php ActiveForm::end(); ?>
  <?php 
      Modal::begin([
          'id'=>'modal',
          'header' => '<b>' . Yii::t('app', 'Datos Cliente') . '</b>',
          'size'=>'modal-lg',
        ]);
      echo "<div id='modalContent'></div>";
      Modal::end();
    ?>
  
<script>
  
  function setCantidad(value){
    var cadena=document.getElementById("txtCantidad").value;
    if (value=="." || value==",") {
      if (!cadena.includes(value)) {
        document.getElementById("txtCantidad").value+=value;
      }
    }
    else{
      document.getElementById("txtCantidad").value+=value;
    }
  }
  function addProducto(id,nombre,precio) {

    var suma=0;
    var table = document.getElementById("tbDetalle");
    var total = document.getElementById("txtTotal");
    var cantidad = parseFloat(document.getElementById("txtCantidad").value);
    if (cantidad<=0 || isNaN(cantidad)) {return;}
    var subtotal=precio*cantidad;
    var row = table.insertRow(1);
    row.id=id;
    row.classList.add("lista");
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    cell1.innerHTML = "<input id='txtCantidad"+id+"' class='tdCantidad' name='cantidad["+id+"]' step=0.01 type='number' value="+cantidad.toFixed(2)+" style='width:70px;padding-left:10px;font-size:11pt' min='0' readonly>";
    cell2.innerHTML = "<p class='tdMat' style='font-size:11pt;padding-top:6px;'>"+nombre+"</p>";
    cell3.innerHTML = "<input type='number' class='sel' value="+precio.toFixed(2)+" step=0.01 onclick='multi(this,"+id+")' onchange='multi(this,"+id+")' style='width:80px;padding-left:10px;font-size:11pt'>";
    cell4.innerHTML = "<input id='txtSubtotal"+id+"' name='precio["+id+"]' type='number' step=0.01 class='tdSubtotal sel' value="+subtotal.toFixed(2)+" onclick='setValor(this)' onkeyup='calcular()' style='width:90px;padding-left:10px;font-size:11pt'>";
    cell5.innerHTML = "<a onclick='borrar("+id+")' class='btn btn-sm btn-danger' ><span class='glyphicon glyphicon-remove'></span></a>";
    $('.tdSubtotal').each(function(){
        suma += parseFloat(this.value);
    });
    total.value=suma.toFixed(2);
    document.getElementById("txtCantidad").value="";
    document.getElementById("incan").value=suma.toFixed(2);
    valid(suma.toFixed(2));
    document.getElementById("btn-"+id).style.visibility = "hidden";
    document.getElementById("txtMateriales").value=getSizeLista();
  }
  
function multi(elemento,id) {
  var valor=parseFloat(document.getElementById("txtCantidad").value);
  var cantidad=document.getElementById("txtCantidad"+id).value;
  if (isNaN(valor) || valor=="") {
    var total=cantidad*elemento.value;
  }
  else
  {
    elemento.value=valor;
    var total=cantidad*elemento.value;
  }
  
  document.getElementById("txtSubtotal"+id).value=total;
  var sum = 0;
  $('.tdSubtotal').each(function(){
      sum += parseFloat(this.value);
  });
  document.getElementById("txtTotal").value=sum.toFixed(2);
  document.getElementById("incan").value=sum.toFixed(2);
  valid(sum.toFixed(2));
  document.getElementById("txtCantidad").value="";
}
function calcular()
{
  var sum = 0;
  $('.tdSubtotal').each(function(){
      sum += parseFloat(this.value);
  });
  document.getElementById("txtTotal").value=sum.toFixed(2);
  document.getElementById("incan").value=sum.toFixed(2);
  valid(sum.toFixed(2));
}
function getSizeLista(){
  var cont=0;
  $('.tdSubtotal').each(function(){
      cont++;
  });
  return cont;
}
function valid(value)
{
  $("#incan").attr({
       "max" : value,        // substitute your own
       "min" : 0          // values (or variables) here
    });
}
function borrar(value) {
    var row = document.getElementById(value);
    row.parentNode.removeChild(row);
    calcular();
    document.getElementById("btn-"+value).style.visibility = "visible";
    document.getElementById("txtMateriales").value=getSizeLista();

}
function clearText(){
  document.getElementById("txtCantidad").value="";
}
function setValor(elemento){
  var cantidad = parseFloat(document.getElementById("txtCantidad").value);

  if (isNaN(cantidad)) {return;}

  if (elemento.id=='incan')
  {
    if ($.getTipo()==1) {
      elemento.value=cantidad.toFixed(2);
      document.getElementById("txtCantidad").value="";
    }
  }
  else
  {

    elemento.value=cantidad.toFixed(2);
    document.getElementById("txtCantidad").value="";
    calcular();
  }
  
}


</script>
</div>
<?php
$script=<<< JS
$("#txtTipo").on("change","input[type=radio]",function(){
    var value=$('[name="Venta[tipo]"]:checked').val();
    if (value==0) {
      calcular();
      $("#incan").prop('readonly', true); 
    }
    if (value==1) {
      $("#incan").val(0);
      $("#incan").prop('readonly', false);

    }
    if (value==2) {
      $("#incan").val(0,00);
      $("#incan").prop('readonly', true);
    }
});

$.getTipo = function() {
  var value=$('[name="Venta[tipo]"]:checked').val();
  return value;
};
$("#searchclear").click(function(){
    $("#txtCantidad").val("");
});
$(".sel").focus(function(){
       $(this).select();
    });
$("#alerta").fadeTo(5000, 500).slideUp(500, function(){
    $("#alerta").slideUp(500);
    });
    
JS;
$this->registerJs($script);
?>