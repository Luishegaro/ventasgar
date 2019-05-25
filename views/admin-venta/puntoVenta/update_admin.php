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
use app\models\ClienteForm;

/* @var $this yii\web\View */
/* @var $venta Venta */

$this->title = 'Nota de Entrega';
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
<div class="container-fluid">
  <?php $form = ActiveForm::begin(); $url = \yii\helpers\Url::to(['admin-venta/deuda']); ?>
  <div class="row">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">MODIFICAR NOTA VENTA</div>
      <div class="panel-body">
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4">
          <input type="hidden" id="txtCliente" value="<?= ClienteForm::getById($venta->id_cliente)->nombre ?>">
          <input type="hidden" id="txtId" value="<?= date_timestamp_get(date_create($venta->_registrado)).$venta->id_cliente?>">
          <input type="hidden" id="txtRegistro" value="<?= date_timestamp_get(date_create($venta->_registrado))?>">
          <input type="hidden" id="id_cliente" value="<?= $venta["id_cliente"] ?>">
          <?=$form->field($venta, 'id_cliente')->widget(Select2::classname(), [
                      'data' => ArrayHelper::map($clientes,'id_cliente','nombre'),
                      'options' => ['placeholder' => 'Selecciona un Cliente..'],
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
                            $('#btnBuscar').text(data.deuda);
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
                  ])->label("Cliente");?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3">
          <?= $form->field($venta, 'fecha')->widget(DatePicker::classname(), [
                  'language' => 'es',
                  'type' => DatePicker::TYPE_COMPONENT_APPEND,
                  'pluginOptions' => [
                      'autoclose'=>true,
                      'format' => 'dd-mm-yyyy'
                  ]])->label("Fecha") ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2">
          <?= $form->field($venta, 'numero')->textInput()->label("Nro. Nota de Venta Fisica") ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="btn-group" role="group" aria-label="..." style="padding-top: 25px;">
            <button type="button" class="btn btn-default" disabled="disabled">DEUDA :</button>
            <?= Html::a('0','javascript:void(0)', ['id'=>'btnBuscar','class'=>'btn btn-danger',]) ?>
          </div>
          <div class="btn-group" role="group" aria-label="..." style="padding-top: 25px;">
            <button type="button" class="btn btn-default" disabled="disabled">SALDO :</button>
            <a id="btnFavor" class=" btn btn-success" href="javascript:void(0)">0</a>
          </div>
        </div>
        
        
        </div>
        <hr style="margin-bottom: 20px;">
        <div class="row">
          
          <div class="col-xs-12 col-sm-3 col-md-2">
            <div class="btn-group">
              <input id="txtCantidad" type="text" style="width: 100%;height:52px;font-size: 24pt;" class="form-control" readonly placeholder="Cant.">
              <span id="searchclear" class="glyphicon glyphicon-remove-circle"></span>
            </div>
            </br>
            <table width="100%">
            <tr >
              <td><a style="padding: 5px;" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)"><h3>1</h3></a></td>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)" ><h3>2</h3></a></td>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)" ><h3>3</h3></a></td>
            </tr>
            <tr>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)" ><h3>4</h3></a></td>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)" ><h3>5</h3></a></td>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)" ><h3>6</h3></a></td>
            </tr>
            <tr>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)" ><h3>7</h3></a></td>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)" ><h3>8</h3></a></td>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)" ><h3>9</h3></a></td>
            </tr>
            <tr>
              <td colspan="2" class="text-right"><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)"><h3>0</h3></a></td>
              <td><a style="padding: 5px" class="btn btn-lg btn-default btn-block" onclick="setCantidad(this.textContent)"><h3>.</h3></a></td>
            </tr>
          </table>
          </div>
          <div class="col-xd-12 col-md-4 pre-scrollable">
            <?php foreach ($materiales as $m):?>
              <div class="col-xs-6 col-sm-6 col-md-4" style="margin-bottom: 30px;">
                <a id="btn-<?=$m["id_material"]?>" class="btn btn-squared-default-plain btn-default" <?php $style=""; ($m["cantidad"]!=0)? $style= "style='visibility:hidden'" : $style=""; echo $style; ?> onclick="addProducto(<?= $m["id_material"] ?>,<?= "'".str_replace('"','',$m["nombre"]) ."'" ?>,<?= $m["precio"] ?>)" style="padding: 0px;">
                    <i><img src="../img/<?= $m["id_material"] ?>.jpg"  class="img-responsive img-rounded" width="100%"></i>
                    <span class="imagebox-desc text-warning" style="font-size:9pt;"><b><?= $m["nombre"] ?></b></span>
                </a>
              </div>
            <?php endforeach ?>
          </div>
          
          <div class="col-xd-12 col-md-6 table-responsive">
            <?= $form->field($venta, 'materiales')->hiddenInput(["id"=>"txtMateriales",'value'=>1])->label(false) ?>
            <table id="tbDetalle" class="table">
              <tr class="danger">
                <th>CANT.</th>
                <th>MATERIAL.</th>
                <th>P. UNIT.</th>
                <th>S. TOTAL</th>
                <th></th>
              </tr>
              <?php foreach ($materiales as $m): ?>
                <?php 
                  if ($m["cantidad"]!=0) {
                    echo "<tr id=".$m["id_material"].">";
                    echo "<td><input id='txtCantidad".$m["id_material"]."' class='tdCantidad' name='cantidad[".$m["id_material"]."]' step=0.01 type='number' value=".$m["cantidad"]." style='width:60px;padding-left:10px' min='0' readonly></td>";
                    echo "<td><p class='tdMat' style='font-size:11pt'>".$m["nombre"]."</p></td>";
                    echo "<td><input type='number' value=".$m["costo"]/$m["cantidad"]." step=0.01 onclick='multi(this,".$m["id_material"].")' onchange='multi(this,".$m["id_material"].")' style='width:70px;padding-left:10px' ></td>";
                    echo "<td><input id='txtSubtotal".$m["id_material"]."' name='precio[".$m["id_material"]."]' type='number' step=0.01 class='sel tdSubtotal' value=".$m["costo"]."  style='width:90px;padding-left:10px' onclick='setValor(this)' onkeyup='calcular()' ></td>";
                    echo "<td><a onclick='borrar(".$m["id_material"].")' class='btn btn-danger
                     btn-sm'><span class='glyphicon glyphicon-remove'></span></a></td>";
                    echo "</tr>";
                  } 
                ?>
              <?php endforeach ?>
              <tr>
                <th colspan="3" class="text-right">TOTAL:</th>
                <th><input id="txtTotal" type="number" name='Venta[total]' step="0.01" style="width: 90px;padding-left:10px" readonly="" value=<?=$venta["total"]?>></th>
                <th></th>
              </tr>
              <tr>
                <th colspan="2" style="border-top: none;"><?= $form->field($venta, 'tipo')->inline()->radioList($tipo,['id'=>'txtTipo','class'=>'btn-group col-md-12','data-toggle'=>'buttons','align'=>'right','item' => function($index, $label, $name, $checked, $value) {
                          if ($checked=="1") {
                            $return = '<label class="btn btn-default col-md-4 active">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" checked>';
                          }
                          else{
                            $return = '<label class="btn btn-default col-md-4">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '">';
                          }
                          $return .= ucwords($label) ;
                          $return .= '</label>';

                          return $return;
                      }])->label(false)?>
                      
                    </th>
                  <th class="text-right" style="border-top: none;">PAGO :</th>
                <th style="border-top: none;"><input id="incan" class="sel" type="number" name='Venta[cancelado]' step="0.01" style="width: 90px;padding-left:10px" onclick='setValor(this)' value=<?=$venta["cancelado"]?> <?php if ($venta["tipo"]!=1) {
                  echo "readonly";
                }?>></th>
               
              </tr>
            </table>
              <p class="text-center">
                <?= Html::submitButton('Guardar', ['id'=>'subcli','class' => 'btn btn-lg btn-primary', 'name' => 'venta-button','onclick'=>'savefire()']) ?>
              </p>
          </div>
        </div>
        <div class="row">
          <?= $form->field($venta, '_usuario')->hiddenInput(['value' => $venta->_usuario])->label(false) ?>
          <?= $form->field($venta, '_registrado')->hiddenInput(['value' => $venta->_registrado])->label(false) ?>
          <div class="col-xs-12 col-md-6">
            <?= $form->field($venta, 'observacion')->textarea(['rows' => '3']) ?>
          </div>
        </div>
        </div>
      </div>
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
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    cell1.innerHTML = "<input id='txtCantidad"+id+"' class='tdCantidad' name='cantidad["+id+"]' step=0.01 type='number' value="+cantidad.toFixed(2)+" style='width:70px;padding-left:10px' min='0' readonly>";
    cell2.innerHTML = "<p class='tdMat' style='font-size:9pt'>"+nombre+"</p>";
    cell3.innerHTML = "<input type='number' value="+precio.toFixed(2)+" step=0.01 onclick='multi(this,"+id+")' onchange='multi(this,"+id+")' style='width:70px;padding-left:10px'>";
    cell4.innerHTML = "<input id='txtSubtotal"+id+"' name='precio["+id+"]' type='number' step=0.01 class='sel tdSubtotal' onkeyup='calcular()' value="+subtotal.toFixed(2)+" style='width:90px;padding-left:10px' onclick='setValor(this)'>";
    cell5.innerHTML = "<a onclick='borrar("+id+")' ><span class='glyphicon glyphicon-remove'></span></a>";
    $('.tdSubtotal').each(function(){
        suma += parseFloat(this.value);
    });
    total.value=suma.toFixed(2);
    document.getElementById("txtCantidad").value=0;
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
function setValor(elemento){
  var cantidad = parseFloat(document.getElementById("txtCantidad").value);

  if (isNaN(cantidad)) {return;}

  if (elemento.id=='incan')
  {
    if ($.getTipo()==1) {
      elemento.value=cantidad;
      document.getElementById("txtCantidad").value=0;
    }
  }
  else
  {

    elemento.value=cantidad;
    document.getElementById("txtCantidad").value=0;
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
      $("#incan").val("");
      $("#incan").prop('readonly', false);

    }
    if (value==2) {
      $("#incan").val(0);
      $("#incan").prop('readonly', true);
    }
});
$("#searchclear").click(function(){
    $("#txtCantidad").val("");
});
$.getTipo = function() {
  var value=$('[name="Venta[tipo]"]:checked').val();
  return value;
};
    $("#alerta").fadeTo(5000, 500).slideUp(500, function(){
        $("#alerta").slideUp(500);
        });
  
JS;
$this->registerJs($script);
?>