<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cli */

$this->title ='Imprimir recibo Nro.'. $model['numero'];
$this->params['breadcrumbs'] = null;
?>
<div class="pago-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id_pago' => $model['id_pago']], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numero',
            'fecha',
            [
                'attribute'=>'nombre',
                'label'=>'Recibí de '
            ],
            
            [
                'attribute'=>'monto',
                'label'=>'La suma de Bs. '
            ],
        ],
    ]) ?>
    <label>Por concepto de:</label>
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
        <?php $total=0; 
        foreach ($materiales as $m) {
          $total=$total+$m["costo"];

          echo "<tr>";
          //echo  "<td class='col-md-1'>".$form->field($venta, 'cantidad')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1' ><p class='text-right'>".$m["cantidad"]."</p></td>";
          echo  "<td class='col-md-2' style='vertical-align:bottom'><p > ".$m["nombre"]."</p></td>";
          
          echo  "<td class='col-md-1' style='vertical-align:bottom'><p class='text-right'>".$m["precio"]."</p></td>";
         
          //echo  "<td class='col-md-1'>".$form->field($venta, 'precio')->textInput(['type' => 'number','min' => 0])."</td>";
          echo  "<td class='col-md-1'><p class='text-right'>".$m["costo"]."</p></td>";
          echo "</tr>";
          } 
          echo "<tr class='info'><td class='col-md-2' style='vertical-align:center' colspan=3><p class='text-right'>TOTAL Bs.</p></td><td class='col-md-1' style='vertical-align:center' ><p class='text-right'>".$total."</p></td></tr>";

          
          ?>
      </table>
    <p>
        <?=
     Html::a('<i class="glyphicon glyphicon-print"></i> Imprimir Recibo', ['print', 'id_pago' => $model["id_pago"]], [
      'class'=>'btn btn-danger', 
      'target'=>'_blank', 
      'data-toggle'=>'tooltip', 
      'title'=>'Abrira una Ventana de impresión'
  ]);
  ?>
    </p>

</div>
