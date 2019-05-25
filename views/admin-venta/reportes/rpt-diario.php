<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\MaterialForm;
use app\components\PTotal;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\DetalleForm;
/* @var $this yii\web\View */
/* @var $search_model app\models\CliSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Reporte de Diario';
$this->params['breadcrumbs'] = null;
?>
<h3 class="text-center"><?= Html::encode($this->title) ?></h3>
<div class="panel panel-default">
  <div class="panel-body" style="padding-bottom: 0px;">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'action' => ['rpt-diario'],
            'method' => 'get',
        ]); ?>
        <div class="col-md-5">
            <?= $form->field($searchModel, 'fecha')->widget(DatePicker::classname(), [
              'language' => 'es',
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'dd-mm-yyyy'
              ]])->label(false) ?>
        </div>
        <div class="col-md-2" style="padding-bottom: 10px;">
          <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Buscar', ['class' => 'btn btn-danger btn-block']) ?>
        </div>
        <div class="col-md-2" style="padding-bottom: 10px;">
          <button class="btn btn-success btn-block" onclick="printData()">IMPRIMIR</button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
<div class="panel panel-default">    
  <div class="panel-body">
   <!-- <div align="center" style="width: 290px">
      <input type="button" onclick="printData()" value="Imprimir">
    </div>-->

<div id="imprimir">
  <table height="100" width="290" style="text-align: center;">
    <tbody>
      <tr>
        <td data-mce-style="text-align: center;" style="text-align: center;">
          <div><span style="font-size:14pt;font-family:verdana,geneva,sans-serif;"><strong>PLANILLA DIARIA</strong></span></div>
          <div><span style="font-size:14pt;"><span style="font-family: comic sans ms,cursive;"><?php $date=(isset($_GET['VentaSearch']['fecha']))?(strtotime($_GET['VentaSearch']['fecha'])):("");
            echo ($date!="")?Yii::$app->formatter->asDate($date,'php:l jS F Y'):"";
         ?></span></span></div>
        </td>
      </tr>
    </tbody>
  </table>
  <div style="font-family: Lucida Sans Typewriter;">
    <h3 style="width: 290px"><div><u>Ventas Efectivo</u></div></h3>
      <table class="mainTable" style="font-size: 12pt; font-family:Lucida Sans Typewriter;">
        <tr>
          <th>
            <label class="control-label" >Nro.</label>
          </th>
          <th>
            <label class="control-label" >Detalle
            </label>
            <div style="width: 290px" align="left">
              <div style="width: 40px; display: inline-block;" align="left">Cant</div>
              <div style="width: 90px;display: inline-block;" align="center">Mat</div>
              <div style="width: 60px;display: inline-block;" align="right">P Unit</div>
              <div style="width: 70px;display: inline-block;" align="right">S Total</div>
            </div>
          </th >
        </tr> 
        <?php
        $total_efectivo=0;
        $total_credito=0;
        $material="";
        $total_pagado=0;
        $retiro=0;

        $tablaEfectivo="";
        $tablaCredito="";
        $tablaRetiro="";

        foreach ($data as $d) {
          if ($d["tipo"]==0) {
            if ($d["_estado"]!="X") {
              $total_efectivo+=$d["cancelado"];
              $material=DetalleForm::getByIdVentaView($d["id_venta"]);
              $tablaEfectivo.= "<tr>";
              
              $tablaEfectivo.= "<td ><p>".$d["id_venta"]."</p></td>";

              $tablaMat="<td><table class='detalleTable' width='290px' style='font-size: 11pt;font-family:Lucida Sans Typewriter;'>";
              foreach ($material as $m) {
                $precio=0;
                $precio=$m["costo"]/$m["cantidad"];
                $tablaMat.="<tr><td width='40px'><div align='right'>".$m["cantidad"]."</div></td>
                      <td width='100px'><p>".$m["nombre"]."</p></td>
                      <td width='60px'><div align='right'>".
                      Yii::$app->formatter->format($precio,['decimal',2])."</div></td>
                      <td width='70px'><div align='right'>".$m["costo"]."</div></td></tr>";
              }
            
              $tablaMat.="</table></td>";
              $tablaEfectivo.= $tablaMat;
            }
            else {
              $tablaEfectivo.= "<tr>";
              $tablaEfectivo.= "<td  ><div>".$d["id_venta"]."</div></td>";
            
              $tablaEfectivo.= "<td ><div align='center'><u>ANULADA</u></div></td>";
            }
          }
          if ($d["tipo"]==1) {
            if ($d["_estado"]!="X") {
              $credito=($d["total"]-$d["cancelado"]);
              $total_credito+=$credito;
              $total_pagado+=$d["cancelado"];
              $material=DetalleForm::getByIdVentaView($d["id_venta"]);
              $tablaCredito.= "<tr>";
              
              $tablaCredito.= "<td ><p>".$d["id_venta"]."</p></td>";

              $tablaMat="<td><table class='detalleTable' width='290px' style='font-size: 11pt;font-family:Lucida Sans Typewriter;'>";
              foreach ($material as $m) {
                $precio=0;
                $precio=$m["costo"]/$m["cantidad"];
                $tablaMat.="<tr><td width='40px'><div align='right'>".$m["cantidad"]."</div></td>
                      <td width='100px'><p>".$m["nombre"]."</p></td>
                      <td width='60px'><div align='right'>".
                      Yii::$app->formatter->format($precio,['decimal',2])."</div></td>
                      <td width='70px'><div align='right'>".$m["costo"]."</div></td></tr>";
              }
            
              $tablaMat.="</table></td>";
              $tablaCredito.= $tablaMat;
            }
            else {
              $tablaCredito.= "<tr>";
              $tablaCredito.= "<td  ><div>".$d["id_venta"]."</div></td>";
            
              $tablaCredito.= "<td ><div align='center'><u>ANULADA</u></div></td>";
            }
          }
          if ($d["tipo"]==2) {
            if ($d["_estado"]!="X") {
              $retiro+=$d["total"];
              $material=DetalleForm::getByIdVentaView($d["id_venta"]);
              $tablaRetiro.= "<tr>";
              
              $tablaRetiro.= "<td ><p>".$d["id_venta"]."</p></td>";

              $tablaMat="<td><table class='detalleTable' width='290px' style='font-size: 11pt;font-family:Lucida Sans Typewriter;'>";
              foreach ($material as $m) {
                $precio=0;
                $precio=$m["costo"]/$m["cantidad"];
                $tablaMat.="<tr><td width='40px'><div align='right'>".$m["cantidad"]."</div></td>
                      <td width='100px'><p>".$m["nombre"]."</p></td>
                      <td width='60px'><div align='right'>".
                      Yii::$app->formatter->format($precio,['decimal',2])."</div></td>
                      <td width='70px'><div align='right'>".$m["costo"]."</div></td></tr>";
              }
            
              $tablaMat.="</table></td>";
              $tablaRetiro.= $tablaMat;
            }
            else {
              $tablaRetiro.= "<tr>";
              $tablaRetiro.= "<td  ><div>".$d["id_venta"]."</div></td>";
            
              $tablaRetiro.= "<td ><div align='center'><u>ANULADA</u></div></td>";
            }
          }
        }
        echo $tablaEfectivo;
        ?>
        <tfoot>
          <tr>
            <th colspan="2"><div align='right'>Total Efectivos <?=Yii::$app->formatter->format($total_efectivo,['decimal',2])?></div></th>
            
          </tr>
        </tfoot>
      </table>
      
      <?php if ($tablaCredito!=""): ?>
        
      <h3 style="width: 290px"><div><u>Ventas Crédito</u></div></h3>
      <table class="mainTable" style="font-size: 12pt; font-family:Lucida Sans Typewriter;">
        <tr>
          <th>
            <label class="control-label" >Nro.</label>
          </th>
          
          <th>
            <label class="control-label" >Detalle
            </label>
            <div style="width: 290px" align="left">
              <div style="width: 40px; display: inline-block;" align="left">Cant</div>
              <div style="width: 90px;display: inline-block;" align="center">Mat</div>
              <div style="width: 60px;display: inline-block;" align="right">P Unit</div>
              <div style="width: 70px;display: inline-block;" align="right">S Total</div>
            </div>
          </th >
        </tr> 
        <?php
        echo $tablaCredito;
        ?>
        <tfoot>
          <tr>
            <th colspan="2"><div align='right'>Pagado <?=Yii::$app->formatter->format($total_pagado,['decimal',2])?></div></th>
            
          </tr>
          <tr>
            <th colspan="2"><div align='right'>Total Credito <?=Yii::$app->formatter->format($total_credito,['decimal',2])?></div></th>
            
          </tr>
        </tfoot>
      </table>
    
      <?php endif ?>
      <?php if ($tablaRetiro!=""): ?>
        
      <h3 style="width: 290px"><div><u>Retiro de Material</u></div></h3>
      <table class="mainTable" style="font-size: 12pt; font-family:Lucida Sans Typewriter;">
        <tr>
          <th>
            <label class="control-label" >Nro.</label>
          </th>
          
          <th>
            <label class="control-label" >Detalle
            </label>
            <div style="width: 290px" align="left">
              <div style="width: 40px; display: inline-block;" align="left">Cant</div>
              <div style="width: 90px;display: inline-block;" align="center">Mat</div>
              <div style="width: 60px;display: inline-block;" align="right">P Unit</div>
              <div style="width: 70px;display: inline-block;" align="right">S Total</div>
            </div>
          </th >
        </tr> 
        <?php
        echo $tablaRetiro;
        ?>
        <tfoot>
          <tr>
            <th colspan="2"><div align='right'>Total Retiro Mat. <?=Yii::$app->formatter->format($retiro,['decimal',2])?></div></th>
            
          </tr>
        </tfoot>
      </table>
      
      <?php endif ?>
    
   <h3>Materiales</h3>
      <?= GridView::widget([
            'dataProvider' => $providerMateriales,
            'class' => 'mainTable',
            'columns' =>[ 
              ['class' => 'yii\grid\SerialColumn'],
              
                [
                  "attribute"=>"nombre",
                  "label"=>"Material",

                ],
                [
                  "attribute"=>"cantidad",
                  "label"=>"Cantidad",
                  'contentOptions' => ['class' => 'text-right'],
                ],
                [
                  "attribute"=>"precio",
                  "label"=>"Total",
                  'contentOptions' => ['class' => 'text-right'],
                ],
            ],
        ]); ?>

    <h3>Recibos de Cobro</h3>
    
      <?= GridView::widget([
            'dataProvider' => $providerRecibos,
            'showFooter'=>TRUE,
            'class' => 'mainTable',
            'columns' => [
              ['class' => 'yii\grid\SerialColumn'],
                [
                  "attribute"=>"id_pago",
                  "label"=>"Nro.",
                ],
                [
                  "attribute"=>"nombre",
                  "label"=>"Recibí de",
                  'contentOptions' => ['style' => 'width:150px'],
                ],
                
                [
                  "attribute"=>"monto",
                  "label"=>"Ingreso Bs.",
                  'footer'=>Yii::$app->formatter->format(PTotal::pageTotal($providerRecibos->allModels,'monto'),['decimal',2]),
                  'contentOptions' => ['class' => 'text-right'],
                  'footerOptions' => ['class' => 'text-right'],
                ],
                
                
            ],
        ]); ?>
  <h3>Resumen de Ingreso</h3>
  <table class="mainTable" style="width: 344px">
      <tr style="border-bottom: hidden;">
        <td><label class="control-label" >Ventas por Cobrar:</label></td>
        <td><div align="right"><?=Yii::$app->formatter->format($total_credito,['decimal',2])?></div></td>
      </tr>
      <tr style="border-bottom: hidden;">
        <td><label class="control-label" >Ventas Efectivo:</label></td>
        <td><div align="right"><?=Yii::$app->formatter->format($total_efectivo+$total_pagado,['decimal',2])?></div></td>
      </tr>
      <tr >
        <td><label class="control-label" >Recibos de Cobro:</label></td>
        <td><div align="right"><?php
        $cobradas=PTotal::pageTotal($providerRecibos->allModels,'monto');
        $tot_ingreso=$total_efectivo+$total_pagado+$cobradas;
        echo Yii::$app->formatter->format($cobradas,['decimal',2]);
        ?></div></td>
      </tr>
      <tr>
        <td><label class="control-label" ><b>Total Ingreso:</b></label></td>
        <td><div align="right"><strong><?= Yii::$app->formatter->format($tot_ingreso,['decimal',2]); ?></strong></div></td>
      </tr>
    </table>


<h3>Recibos de Gasto</h3>
    <?= GridView::widget([
        'dataProvider' => $providerGastos,
        'showFooter'=>TRUE,
        'class' => 'mainTable',
        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
            [
              "attribute"=>"id_gasto",
              "label"=>"Nro.",
            ],
            [
              "attribute"=>"pagado_a",
              "label"=>"Pagado a",
              'contentOptions' => ['style' => 'width:200px'],
            ],
            [
              "attribute"=>"monto",
              "label"=>"Egreso Bs.",
              'footer'=>Yii::$app->formatter->format(PTotal::pageTotal($providerGastos->allModels,'monto'),['decimal',2]),
              'contentOptions' => ['style' => 'width:100px','class' => 'text-right'],
              'footerOptions' => ['class' => 'text-right'],
            ],
            
            
        ],
    ]); ?>
<h3>Arqueo de Caja</h3>
    <table class="mainTable" style="width: 344px">
      <tr style="border-bottom: hidden;">
        <td><label class="control-label" >Total Ingresos:</label></td>
        <td><div align="right"><?= Yii::$app->formatter->format($tot_ingreso,['decimal',2]) ?></div></td>
      </tr>
      <tr >
        <td><label class="control-label" >(-) Gastos:</label></td>
        <td><div align="right"><?php $gastos=PTotal::pageTotal($providerGastos->allModels,'monto');
        echo Yii::$app->formatter->format($gastos,['decimal',2]);
        ?></div></td>
      </tr>
      <tr>
        <td><label class="control-label" ><b>Efectivos del Día:</b></label></td>
        <td><div align="right"><b><?php
        $efectivo_dia=$tot_ingreso-$gastos;
        
        echo Yii::$app->formatter->format($efectivo_dia,['decimal',2]);
        ?></b></div></td>
      </tr>
    </table>
  </div>
</div>

      </div>
    </div>
<div id="section-to-print"></div>
<script type="text/javascript">
    function printData()
    { 
      var ventas = document.getElementById("imprimir").outerHTML;
      var print=document.getElementById("section-to-print");
      print.innerHTML = ventas;
      window.print();
      print.innerHTML = "";
    }
    

</script>
<style>
table.mainTable {
    border-collapse: collapse;

}
.mainTable td, .mainTable th {
    border: 1px solid black;
    padding: 3px;
}
 .detalleTable td, .detalleTable th {
    border: 1px solid white;
    border-bottom: 1px;
    padding: 3px;
}
table.table {
    border-collapse: collapse;
    width: 344px;
    border: 1px solid black;
}
.table th {
    border: 1px solid black;
    padding: 3px;
}
.table tfoot {
    border: 1px solid black;
    padding: 3px;
}
.table td {
    border-right: 1px solid black;
    border-left: 1px solid black;
    padding: 3px;
}
.text-right{
  text-align: right;
}


@media print {
      body * {
        visibility: collapse;
      }
      #section-to-print, #section-to-print * {
        visibility: visible;
      }
      #section-to-print {
        position: absolute;
        left: 0;
        top: 0;
      }
      
    }


</style>

