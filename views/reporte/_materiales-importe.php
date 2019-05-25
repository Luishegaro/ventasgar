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
<div id="importe-grid">

    <h4 class="text-center">Resumen de Materiales</h4>
    <p class="text-center"><b>Desde: <?= Yii::$app->formatter->format($model->fecha_inicio, 'date')  ?> Hasta: <?= Yii::$app->formatter->format($model->fecha_fin, 'date')  ?></b></b><br><button type="button" class="btn btn-danger" onclick="printImporte()" ><i class="glyphicon glyphicon-print"></i> Imprimir</button></p>
    
    <div id="chart-bar" class="col-md-8 col-md-offset-2">

    <?php 
        $label=[];
        $data=[];
        $dataM3=[];
        foreach ($materiales as $m) {
          if ($m['importe']==0 && $m['m3']==0) {
            continue;
          }
          array_push($label, $m["nombre"]);
          array_push($data, $m["importe"]);
          array_push($dataM3, $m["m3"]);
        }
        
     ?>
     <div  class="panel panel-primary">
        <div class="panel-heading"><strong>Gráfico</strong></div>
        <div  class="panel-body">
            <?= ChartJs::widget([
                'id'=>'importeBarChart',
                'type' => 'horizontalBar',
                'options' => [
                    'height' => 200,
                    'width' => 200,
                    

                ],
                
                'data' => [
                    'labels' => $label,
                    'datasets' => [
                        [
                            'label' => "M3",
                            'backgroundColor' => "#70db70",
                            'borderColor' => "#248f24",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => $dataM3
                        ],
                        [
                            'label' => "Importe Bs.",
                            'backgroundColor' => "#8080ff",
                            'borderColor' => "#000099",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => $data
                        ],

                    ]

                ]
            ]);
            ?>
        </div>
      </div>
    </div>
    <img id="imgchart" src="" height="600" width="800" style="display: none;">
    
    
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
      var canvas = document.getElementById("importeBarChart");
      var chart=document.getElementById("chart-bar").style.display="none";  
      var img= canvas.toDataURL("image/png");
      var elem = document.getElementById("imgchart");
      elem.setAttribute("src", img);
      elem.style.display="inline";

      
      setTimeout(function() {
        var imprimir = document.getElementById("importe-grid").outerHTML;
        var print=document.getElementById("section-to-print");
        print.innerHTML = imprimir;
        window.print();
        print.innerHTML = "";
        elem.style.display="none";
        document.getElementById("chart-bar").style.display="block";
      }, 500);

      
    }

</script>
