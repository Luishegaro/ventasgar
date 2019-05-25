<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\components\PTotal;
use app\models\MaterialForm;
use app\models\DetalleForm;
/* @var $this yii\web\View */
/* @var $search_model app\models\CliSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'REPORTE ARQUEO DE CAJA';
?>
<div class="panel panel-success">
    <div class="panel-heading text-center">
      <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
      <div class="cli-search">
<div class="row">
    <div class="col-lg-5">
    <?php $form = ActiveForm::begin([
        'action' => ['rpt-ventas'],
        'method' => 'get',
    ]); ?>

   <?= $form->field($searchModel, 'fecha')->widget(DatePicker::classname(), [
          'language' => 'es',
          'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'yyyy-mm-dd'
          ]]) ?>
    <div class="form-group">
        <?= Html::submitButton('Generar', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>

</div>
<input type="button" onclick="printData()" value="Imprimir Ventas">
    <div id="seccion-ventas" class="center-block">
      <h3>Planilla de venta al <?php $date=(isset($_GET['VentaSearch']['fecha']))?(strtotime($_GET['VentaSearch']['fecha'])):("");
echo ($date!="")?Yii::$app->formatter->asDate($date,'php:l jS F Y'):"";
       ?></h3>
    
      <table class="table table-condensed">
        <tr>
          
          <th>
            <label class="control-label" >Nro. Recibo</label>
          </th>
          <th>
            <label class="control-label" >E</label>
          </th>
          <th>
            <label class="control-label" >Nombre</label>
          </th>
          
          <th>
            <label class="control-label" >Vtas. Efectivo(Bs.)</label>
          </th>
          <th>
            <label class="control-label" >Vtas. Crédito(Bs.)</label>
          </th>
          <th>
            <label class="control-label" >Concepto</label>
          </th>
          <th>
            <label class="control-label" >Cant.</label>
          </th>
          <th>
            <label class="control-label" >Precio</label>
          </th>
          <th>
            <label class="control-label" >Sub. Total</label>
          </th>
        </tr> 
        <?php
        $total_efectivo=0;
        $total_credito=0;
        $material="";
        $total_cancelado=0;
        foreach ($data as $d) {
          if ($d["_estado"]!="X") {
            $total_cancelado=$d["total"]-$d["cancelado"];
            
            $material=DetalleForm::getByIdVentaView($d["id_venta"]);
            $filas=sizeof($material);
            echo "<tr>";
            
            echo "<td class='col-md-1' rowspan='".$filas."'><p>".$d["id_venta"]."</p></td>";
            echo "<td class='col-md-1' rowspan='".$filas."'><p>".$d["_estado"]."</p></td>";
          
            echo "<td class='col-md-3' rowspan='".$filas."'><p style='font-size:9pt'>".$d["nombre"]."</p></td>";
            switch ($d["tipo"]) {
                case 0:
                    $total_efectivo=$total_efectivo+$d["cancelado"];
                    echo  "<td class='success' rowspan='".$filas."'><div align='right'><strong>".$d["cancelado"]."</strong></div></td>";
                    echo  "<td class='danger' rowspan='".$filas."'><div align='right'><strong>".number_format($total_cancelado,2)."</strong></div></td>";
                    break;
                case 1:
                    echo  "<td class='success' rowspan='".$filas."'><div align='right'><strong>".$d["cancelado"]."</strong></div></td>";
                    echo  "<td class='danger' rowspan='".$filas."'><div align='right'><strong>".number_format($total_cancelado,2)."</strong></div></td>";
                    $total_credito+=$total_cancelado;
                    $total_efectivo=$total_efectivo+$d["cancelado"];
                    break;
                case 2:
                    
                    echo  "<td class='success' rowspan='".$filas."'><div align='right'><strong>".$d["cancelado"]."</strong></div></td>";
                    echo  "<td class='danger' rowspan='".$filas."'><div align='right'><strong>".number_format(0,2)."</strong></div></td>";
                    break;
            }
            
            

            foreach ($material as $m) {
              $precio=0;
              $precio=$m["costo"]/$m["cantidad"];
              echo "
                      <td><p style='font-size:9pt'>".$m["nombre"]."</p></td>
                      <td> <div align='right'>".$m["cantidad"]."</div></td>
                      <td> <div align='right'>".number_format($precio,2)."</div></td>
                      <td> <div align='right'>".$m["costo"]."</div></td>

                    </tr>";
              echo "<tr>";
            }
          }
          else
          {
            echo "<tr>";
            
            echo "<td class='col-md-1' ><p>".$d["id_venta"]."</p></td>";
            echo "<td class='col-md-1' ><p>".$d["_estado"]."</p></td>";
          
            echo "<td class='col-md-2' ><p style='font-size:9pt'>Anulada</p></td>";
            echo "<td class='col-md-2' ><div align='right'>0.00</div></td>";
            echo "<td class='col-md-2' ><div align='right'>0.00</div></td>";
          }
          
          
         }
        ?>
        <tfoot>
          <tr>
            <th colspan="3">Total</th>
            <th><div align='right'><?=number_format($total_efectivo,2)?></div></th>
            <th><div align='right'><?=number_format($total_credito,2)?></div></th>
          </tr>
        </tfoot>
      </table>

    <?php
    $matColumns=[
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
                  
              ];
    ?>

    <h3>Materiales</h3>
    <div class="row">
      <div class="col-xs-9">
        <?= GridView::widget([
              'dataProvider' => $providerMateriales,
              'id' => 'recibos-grid',
              'columns' => $matColumns,
          ]); ?>
        </div>
    </div>

    <h3>Recibos de Cobro</h3>
    <div class="row">
      <div class="col-xs-9">
        <?= GridView::widget([
              'dataProvider' => $providerRecibos,
              'showFooter'=>TRUE,
              'id' => 'recibos-grid',
              'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                "fecha",
                  [
                    "attribute"=>"id_pago",
                    "label"=>"Nro.",
                  ],
                  [
                    "attribute"=>"nombre",
                    "label"=>"Recibí de",
                  ],
                  [
                    "attribute"=>"concepto",
                    "label"=>"Por concepto de",
                    'format'=>'html',
                  ],
                  
                  [
                    "attribute"=>"monto",
                    "label"=>"Ingreso Bs.",
                    'footer'=>PTotal::pageTotal($providerRecibos->allModels,'monto'),
                  ],
                  
                  
              ],
          ]); ?>
        </div>
    </div>
  <h3>Resumen de Ingreso</h3>
<div class="row">
  <div class="col-xs-5">
    <table class="table table-bordered">
      <tr>
        <td><label class="control-label" >Ventas por Cobrar</label></td>
        <td><div align="right"><?= number_format($total_credito,2) ?></div></td>
      </tr>
      <tr>
        <td><label class="control-label" >Ventas Efectivo</label></td>
        <td><div align="right"><?= number_format($total_efectivo,2) ?></div></td>
      </tr>
      <tr>
        <td><label class="control-label" >Recibos de Cobro</label></td>
        <td><div align="right"><?php
        $cobradas=PTotal::pageTotal($providerRecibos->allModels,'monto');
        $tot_ingreso=$total_efectivo+$cobradas;
        echo number_format($cobradas,2);
        ?></div></td>
      </tr>
      <tr>
        <td><label class="control-label" >Total Ingreso</label></td>
        <td><div align="right"><strong><?= number_format($tot_ingreso,2) ?></strong></div></td>
      </tr>
    </table>
  </div>
</div>
</div>
<input type="button" onclick="printGastos()" value="Imprimir Gastos">
<div id="seccion-gastos">
    <h3>Recibos de Gasto</h3>
<div class="row">
  <div class="col-xs-9">

    <?= GridView::widget([
        'dataProvider' => $providerGastos,
        'showFooter'=>TRUE,
        'id' => 'gastos-grid',
        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          "fecha",
            [
              "attribute"=>"id_gasto",
              "label"=>"Nro.",
            ],
            [
              "attribute"=>"pagado_a",
              "label"=>"Pagado a",
            ],
            [
              "attribute"=>"concepto",
              "label"=>"Por concepto de",

            ],
            [
              "attribute"=>"nro_factura",
              "label"=>"Nro Factura/Recibo",
            ],
            [
              "attribute"=>"monto",
              "label"=>"Egreso Bs.",
              'footer'=>PTotal::pageTotal($providerGastos->allModels,'monto'),
            ],
            
            
        ],
    ]); ?>
  </div>
</div>
<h3>Arqueo de Caja</h3>
<div class="row">
  <div class="col-xs-5">
    <table class="table table-bordered">
      <tr>
        <td><label class="control-label" >Ingresos por Ventas</label></td>
        <td><div align="right"><?= number_format($tot_ingreso,2) ?></div></td>
      </tr>
      <tr>
        <td><label class="control-label" >(-) Gastos</label></td>
        <td><div align="right"><?php $gastos=PTotal::pageTotal($providerGastos->allModels,'monto');
        echo number_format($gastos,2);
        ?></div></td>
      </tr>
      <tr>
        <td><label class="control-label" >Efectivos del Día</label></td>
        <td><div align="right"><?php
        $efectivo_dia=$tot_ingreso-$gastos;
        
        echo number_format($efectivo_dia,2);
        ?></div></td>
      </tr>
    </table>
  </div>
</div>
</div>
<div id="section-to-print"></div>
    </div>
  </div>
</div>
<style type="text/css">
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
    tfoot {
      background-color: #e0e0d1;
      
    }
</style>
<script type="text/javascript">
    function printData()
    { 
      var ventas = document.getElementById("seccion-ventas").outerHTML;
      var print=document.getElementById("section-to-print");
      print.innerHTML = ventas;
      window.print();
      print.innerHTML = "";
    }
    function printGastos()
    {
      var gastos = document.getElementById("seccion-gastos").outerHTML;
      var print=document.getElementById("section-to-print");
      print.innerHTML = gastos;
      window.print();
      print.innerHTML = "";
    }

</script>

