<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Reporte;
use app\components\PTotal;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CliSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div id="linem3-grid">

    <h4 class="text-center">Materiales M3</h4>
    <p class="text-center"><b>Desde: <?= Yii::$app->formatter->format($model->fecha_inicio, 'date')  ?> Hasta: <?= Yii::$app->formatter->format($model->fecha_fin, 'date')  ?></b><br><button type="button" class="btn btn-danger" onclick="printImporte()" ><i class="glyphicon glyphicon-print"></i> Imprimir</button></p>
    
    <div id="chart-line" class="col-md-12">

    <?php 
        $label=[];
        $dataset=[];
        
        foreach ($resumen as $r) {
          array_push($label,  Yii::$app->formatter->asDate($r["fecha"],'php:D-d'));
          
        }
        foreach ($materiales as $m) {
          if ($m["importe"]==0 && $m["m3"]==0) {
            continue;
          }
          $color="rgba(".rand(0,255).",".rand(0,255).",".rand(0,255);
          $campos=[
            'label' => $m["nombre"],
            'backgroundColor' => $color.",0.2)",
            'borderColor' =>  $color.",1)",
            'pointBackgroundColor' => "rgba(179,181,198,1)",
            'pointBorderColor' => "#fff",
            'pointHoverBackgroundColor' => "#fff",
            'pointHoverBorderColor' => "rgba(179,181,198,1)",
            'data'=>'',
          ];
          $m3=[];
          foreach ($resumen as $k) {
            $detalle=Reporte::getMaterialByIdAndFecha($m["id_material"],$k["fecha"]);
            array_push($m3,$detalle['cantidad']);

          }
          $campos["data"]=$m3;
          array_push($dataset, $campos);
        }
        
        
     ?>
     <div  class="panel panel-primary">
        <div class="panel-heading"><strong>Gráfico M3</strong></div>
        <div  class="panel-body">
            
            <?= ChartJs::widget([
              'type' => 'line',
              'id' => 'linem3canvas',
              'options' => [
                  'height' => 200,
                  'width' => 300
              ],
              'data' => [
                  'labels' => $label,
                  'datasets' => $dataset,
              ]
          ]);
          ?>
        </div>
      </div>
    </div>
    <img id="imglinem3" src="" height="600" width="800" style="display: none;">
    
    
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
    function printImporte()
    {
      var canvas = document.getElementById("linem3canvas");
      var chart=document.getElementById("chart-line").style.display="none";  
      var img= canvas.toDataURL("image/png");
      var elem = document.getElementById("imglinem3");
      elem.setAttribute("src", img);
      elem.style.display="inline";

      
      setTimeout(function() {
        var imprimir = document.getElementById("linem3-grid").outerHTML;
        var print=document.getElementById("section-to-print");
        print.innerHTML = imprimir;
        window.print();
        print.innerHTML = "";
        elem.style.display="none";
        document.getElementById("chart-line").style.display="block";
      }, 500);

      
    }

</script>
