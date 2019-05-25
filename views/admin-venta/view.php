<?php

/* @var $this yii\web\View */
/* @var $patrimonio Patrimonio */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

$this->title = $venta->id_venta;
$this->params['breadcrumbs'] = null
?>
<!--<h1>Nota de Venta Nro. <?= Html::encode($this->title) ?></h1>
<p>
<?=
     Html::a('<i class="glyphicon glyphicon-print"></i> Imprimir Nota de Venta', '#', [
      'class'=>'btn btn-danger', 
      'data-toggle'=>'tooltip', 
      'title'=>'Abrira una Ventana de impresión',
      'onclick'=>'imprimirTicket()'
  ]);
  ?>
   <?= Html::a('Nota de Venta', ['principal'], ['class' => 'btn btn-success']) ?>
</p>-->
<div class="row" style="margin-top: 20px;">
  <div class="panel-group col-md-4 col-md-offset-3" >
    <div class="panel panel-default">
      <div class="col-md-12 text-center" >
        <h4>
          <strong>
           NOTA DE ENTREGA 
          <br>
          NRO. <?=$venta->id_venta ?>
          </strong>
        </h4>
      </div>

        <div class="panel-body" style="padding-bottom: 0px">
          <p style="margin-bottom: 0px"><strong>Fecha : </strong> <?=$venta->fecha?></p>
          <p style="margin-bottom: 0px"><strong>Cliente : </strong><?=$venta->nombre?></p>
          <p><strong>Tipo de Cobro : </strong>
            <?php if($venta->tipo==0): ?>
                  Efectivo
             <?php endif; ?>
             <?php if($venta->tipo==1): ?>
                  Crédito
             <?php endif; ?>
             <?php if($venta->tipo==2): ?>
                 Retiro de Material
             <?php endif; ?>
          </p>

          <!--
          <?= DetailView::widget([
            'model' => $venta,
            'attributes' => [
              [
                'attribute'=>'fecha',
                'format'=> ['date', 'php:D, d-m-Y']
              ],
            ],
          ]); ?>
          <?= DetailView::widget([
            'model' => $venta,
            'attributes' => [
              'nombre',
            ],
          ]); ?>
          <?= DetailView::widget([
            'model' => $venta,
            'attributes' => [
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
                      return "Retiro de Material";
                    break;
                  }
      
                }
              ],
            ],
          ]); ?>-->
        </div>
      <div class="panel-body">
        <table class="table">
              <tr style="margin-bottom: 15px">
                <th >
                  <label class="control-label" >CANT.</label>
                </th>
                <th>
                  <label class="control-label" >DETALLE</label>
                </th>
                <th>
                  <label class="control-label" >P.UNIT. (Bs)</label>
                </th>
                <th>
                  <label class="control-label" >P.TOTAL (Bs)</label>
                </th>
              </tr> 
            <?php 
            foreach ($materiales as $m) {

              echo "<tr>";
              //echo  "<td class='col-md-1'>".$form->field($venta, 'cantidad')->textInput(['type' => 'number','min' => 0])."</td>";
              echo  "<td >".$m["cantidad"]."</td>";
              echo  "<td >".$m["nombre"]."</td>";
              $precio=$m['costo']/$m['cantidad'];
              
              echo  "<td >".number_format($precio,2)."</td>";
             
              //echo  "<td class='col-md-1'>".$form->field($venta, 'precio')->textInput(['type' => 'number','min' => 0])."</td>";
              echo  "<td class='text-right'>".$m["costo"]."</td>";
              echo "</tr>";
              } 
              echo "<tr><td colspan=3 class='text-right'>TOTAL Bs.</td><td class='info text-right'>".$venta["total"]."</td></tr>";
              echo "<tr><td colspan=3 class='text-right' style='border-top:none'>CANCELADO Bs.</td><td class='info text-right' style='border-top:none'>".$venta["cancelado"]."</td></tr>";
              ?>
          </table>
          </div>
        </div>
  </div>
  <div class="col-md-2">
    <?=
       Html::a('<i class="glyphicon glyphicon-print"></i> Imprimir Nota de Venta', '#', [
        'class'=>'btn btn-danger btn-block', 
        'data-toggle'=>'tooltip', 
        'title'=>'Abrira una Ventana de impresión',
        'onclick'=>'imprimirTicket()'
    ]);
    ?>
    <br>
     <?= Html::a('Nota de Venta', ['principal'], ['class' => 'btn btn-success btn-block']) ?>
  </div>
</div>

<script type="text/javascript">
    function load() {
      printJS('../web/pdfs/ticket.pdf');
    }
    window.onload = load;
    function imprimirTicket(){
      printJS('../web/pdfs/ticket.pdf');
    }
  
</script>