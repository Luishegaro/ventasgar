<?php

/* @var $this yii\web\View */
/* @var $patrimonio Patrimonio */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

$this->title = $venta->id_venta;
$this->params['breadcrumbs'] = null;
?>
<h1>Imprimir Nota de Venta Nro. <?= Html::encode($this->title) ?></h1>
<p>
  <?= Html::a('Modificar', ['pvt-update', 'id' => $venta['id_venta']], ['class' => 'btn btn-primary']) ?>
</p>

<div class="patrimonio-view">
  <div class="row">
      <div class="col-lg-5">

        <?= DetailView::widget([
        'model' => $venta,
        'attributes' => [
          'id_venta',
          'fecha',
          'nombre',
          [
            'label'  => 'Tipo de Cobro',
            'value'  => function ($data) {
              switch ($data->tipo) {
                case 0:
                  return "Efectivo";
                  break;
                case 1:
                  return "Por Cobrar";
                break;
                case 2:
                  return "Adelantado";
                break;
              }
  
            }
          ],
        ],
      ]); ?>
      </div>
    </div>
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
        <?php 
        foreach ($materiales as $m) {

          echo "<tr>";
          //echo  "<td class='col-md-1'>".$form->field($venta, 'cantidad')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1' ><p class='text-right'>".$m["cantidad"]."</p></td>";
          echo  "<td class='col-md-2' style='vertical-align:bottom'><p > ".$m["nombre"]."</p></td>";
          $precio=$m['costo']/$m['cantidad'];
          
          echo  "<td class='col-md-1' style='vertical-align:bottom'><p class='text-right'>".number_format($precio,2)."</p></td>";
         
          //echo  "<td class='col-md-1'>".$form->field($venta, 'precio')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1'><p class='text-right'>".$m["costo"]."</p></td>";
          echo "</tr>";
          } 
          echo "<tr class='info'><td class='col-md-2' style='vertical-align:center' colspan=3><p class='text-right'>TOTAL Bs.</p></td><td class='col-md-1' style='vertical-align:center' ><p class='text-right'>".$venta["total"]."</p></td></tr>";

          echo "<tr class='info'><td class='col-md-2' style='vertical-align:right' colspan=3> <p class='text-right'>CANCELADO Bs.</p></td><td class='col-md-1'><p class='text-right'>".$venta["cancelado"]."</p></td></tr>";
          ?>
      </table>
    </div>

</div>
<p>
  <?=
     Html::a('<i class="glyphicon glyphicon-print"></i> Imprimir Nota de Venta', ['print', 'id' => $venta->id_venta], [
      'class'=>'btn btn-danger', 
      'target'=>'_blank', 
      'data-toggle'=>'tooltip', 
      'title'=>'Abrira una Ventana de impresión'
  ]);
  ?>
</p>
<p>
  <?= Html::a('Nota de Venta', ['principal'], ['class' => 'btn btn-success']) ?>
</p>

