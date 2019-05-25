<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\MaterialForm;
use app\models\DetalleForm;

/* @var $this yii\web\View */
/* @var $search_model app\models\CliSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cli-search">
<div class="row">
    <div class="col-lg-5">
    <?php $form = ActiveForm::begin([
        'action' => ['rpt-ventas'],
        'method' => 'get',
    ]); ?>

    <?php

        echo '<label class="control-label">Seleccionar Fecha</label>';
        echo DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'fecha_inicio',
            'attribute2' => 'fecha_fin',
            'options' => ['placeholder' => 'Fecha Inicio'],
            'options2' => ['placeholder' => 'Fecha Fin'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);
    ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Generar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Actualizar', ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>

</div>
<input type="button" onclick="printData()" value="Imprimir">
    <div id="section-to-print" class="center-block">
    
      <table class="table table-bordered">
        <tr>
          <th>
            <label class="control-label" >Fecha</label>
          </th>
          <th>
            <label class="control-label" >Nro. Recibo</label>
          </th>
          <th>
            <label class="control-label" >Nombre</label>
          </th>
          <?php
            $lista=MaterialForm::getMateriales();
            foreach ($lista as $l) {
                echo "<th colspan='2'><label class='control-label' >".$l["nombre"]."</label></th>";
            }
          ?>
          
          <th>
            <label class="control-label" >Tipo</label>
          </th>
          <th>
            <label class="control-label" >Importe(Bs.)</label>
          </th>
        </tr> 
        <?php
        $suma=0;
        $material="";
        foreach ($data as $d) {
            echo "<tr>";
          
            echo  "<td class='col-md-2'>".$d["fecha"]."</td>";
            echo  "<td class='col-md-1'><p > ".$d["numero"]."</p></td>";
          
            echo  "<td class='col-md-1'><p>".$d["nombre"]."</p></td>";
            $material=MaterialForm::getMaterialesByIdRecibo($d["id_recibo"]);
            $c=0;
            foreach ($material as $m) {
                echo "<td class='col-md-1'><div class='mat".$c."' align='right'>".$m["cantidad"]."</div></td>";
                echo "<td class='col-md-1'><p class='text-right'>".$m["precio"]."</p></td>";
                $c++;

            }
            switch ($d["tipo"]) {
                case 0:
                    echo  "<td class='col-md-2'><p >Efectivo</p></td>";
                    break;
                case 1:
                    echo  "<td class='col-md-2'><p >A Crédito</p></td>";
                    break;
                case 2:
                    echo  "<td class='col-md-2'><p >Sin Pago</p></td>";
                    break;
                
                default:
                    # code...
                    break;
            }
           
            echo  "<td class='col-md-2'><p class='align-right'><div class='importe' align='right'>".$d["cancelado"]."</div></td>";
            echo "</tr>";
            $suma=$suma+$d["cancelado"];
            
         }
        ?>
        <tfoot>
        <tr>
          <td colspan="3">
            <label class="control-label" >TOTAL</label>
          </td>
          
          <?php
            $t=sizeof($material);
            for ($i=0; $i < $t; $i++) { 
                echo "<td><strong><div id='tot".$i."' align='right'></div></strong></td>";
                echo "<td><div></div></td>";
            }

          ?>
          
          <td>
            <label class="control-label" ></label>
          </td>
          <td>
            <div id="total" align="right"><strong><?= $suma ?></strong></div>
          </td>
        </tr>
        </tfoot>
        
          
      </table>
    </div>
    <input id="size" type="hidden" value=<?= sizeof($material) ?> >

</div>
<style type="text/css">
    @media print {
      body * {
        visibility: hidden;
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
       window.print();
    }

</script>
<?php
  $script=<<<JS
    $(function() {
        var s=$('#size').val();
        for (i = 0; i < s; i++) {
            var sum=0;
            $(".mat"+i).each(function(){
              sum += parseFloat($(this).text());
            });
            $('#tot'+i).text(sum);
        }
    });
JS;
$this->registerJs($script);
