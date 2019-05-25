<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ClienteForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cli */

$this->title ='NRO. '. $model['id_pago'];
$this->params['breadcrumbs'] = null;
?>
<div class="pago-view">
  <div class="row">
    <div class="col-sm-12 col-md-4 col-md-offset-3" style="margin-top: 10px">
  <div class="panel panel-default">
    <div class="text-center">
      <h5>RECIBO DE COBRO <br>
      <?= Html::encode($this->title) ?></h5>
    </div>
    <div class="panel-body">
  <?php if (!empty($materiales)) {?>
     <p style="margin-bottom: 0px"><strong>Fecha : </strong><?= $model->fecha ?></p>
      <p style="margin-bottom: 0px"><strong>Recibi de : </strong><?= ClienteForm::getById($model->id_cliente)->nombre;?></p>
      <p style="margin-bottom: 0px"><strong>La suma de : </strong><?= $model->monto ?> Bolivianos</p>
   <!-- <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha',
            [
                'attribute'=>'id_cliente',
                'label'=>'Recibí de ',
                'value'=>function($model){
                  return ClienteForm::getById($model->id_cliente)->nombre;
                }
            ],
            
            [
                'attribute'=>'monto',
                'label'=>'La suma de Bs. '
            ],
        ],
    ]) ?>-->

    <p><strong> Por concepto de :</strong></p>
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
        <?php $total=0; 
        foreach ($materiales as $m) {
          $total=$total+$m["costo"];

          echo "<tr>";
          //echo  "<td class='col-md-1'>".$form->field($venta, 'cantidad')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td  ><p class='text-right'>".$m["cantidad"]."</p></td>";
          echo  "<td  style='vertical-align:bottom'><p > ".$m["nombre"]."</p></td>";
          
          echo  "<td  style='vertical-align:bottom'><p class='text-right'>".$m["precio"]."</p></td>";
         
          //echo  "<td >".$form->field($venta, 'precio')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td ><p class='text-right'>".$m["costo"]."</p></td>";
          echo "</tr>";
          } 
          echo "<tr><td style='vertical-align:center' colspan=3><p class='text-right'>TOTAL Bs.</p></td><td  class='info' style='vertical-align:center' ><p class='text-right'>".$total."</p></td></tr>";

          
          ?>
      </table>
   <?php } 
   else{ 
    ?>
     <p style="margin-bottom: 0px"><strong>Fecha : </strong><?= $model->fecha ?></p>
      <p style="margin-bottom: 0px"><strong>Recibi de : </strong><?= ClienteForm::getById($model->id_cliente)->nombre;?></p>
      <br>
       <p style="margin-bottom: 0px"><strong>Por concepto de : </strong><?= $model->concepto ?></p>
      <p style="margin-bottom: 0px"><strong>La suma de : </strong><?= $model->monto ?> Bolivianos</p>
   <!--<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha',
            [
                'attribute'=>'id_cliente',
                'label'=>'Recibí de ',
                'value'=>function($model){
                  return ClienteForm::getById($model->id_cliente)->nombre;
                }
            ],
            [
                'attribute'=>'concepto',
                'label'=>'Por concepto de '
            ],
            [
                'attribute'=>'monto',
                'label'=>'La suma de Bs. '
            ],
        ],
    ]) ?>-->
    <?php } 
    ?>
    <br>
    </div>
  </div>
</div>
  <div class="col-md-2" style="margin-top: 10px">
    <?=
     Html::a('<i class="glyphicon glyphicon-print"></i> Imprimir Recibo', '#', [
      'class'=>'btn btn-danger btn-block',
      'data-toggle'=>'tooltip', 
      'title'=>'Abrira una Ventana de impresión',
      'onclick'=>'imprimirRecibo()'
  ]);
  ?>
  </div>
  </div>
</div>
<script type="text/javascript">
  
    function load() {
      printJS('../web/pdfs/recibo.pdf');
    }
    window.onload = load;
    function imprimirRecibo(){
      printJS('../web/pdfs/recibo.pdf');
    }
  
</script>
