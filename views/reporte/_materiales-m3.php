<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\DetalleForm;
use app\models\Reporte;
use app\components\PTotal;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CliSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div id="m3-grid">

    <h4 class="text-center">Resumen de Materiales M3</h4>
    <p class="text-center"><b>Desde: <?= Yii::$app->formatter->format($model->fecha_inicio, 'date')  ?> Hasta: <?= Yii::$app->formatter->format($model->fecha_fin, 'date')  ?></b><br><b>Bolivianos</b><br><button type="button" class="btn btn-danger" onclick="printM3()" ><i class="glyphicon glyphicon-print"></i> Imprimir</button></p>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Resumen</strong></div>
            <div class="panel-body">
                <?php 
                    $dataProvider = new \yii\data\ArrayDataProvider([
                        'allModels' => $materiales,
                        'pagination' => false
                    ]);

                  ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'showFooter'=>TRUE,
                        'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'nombre',
                            [
                              "attribute"=>"m3",
                              'format'=>['decimal',2],
                              'contentOptions' => ['class' => 'text-right'],
                              'footer'=>Yii::$app->formatter->asDecimal(PTotal::pageTotal($dataProvider->allModels,'m3'),2),
                              'footerOptions' => ['class' => 'text-right'],
                            ],
                            [
                              "attribute"=>"importe",
                              'format'=>['decimal',2],
                              'contentOptions' => ['class' => 'text-right'],
                              'footer'=>Yii::$app->formatter->asDecimal(PTotal::pageTotal($dataProvider->allModels,'importe'),2),
                              'footerOptions' => ['class' => 'text-right'],
                            ],
                        ],
                    ]); ?>

            </div>
        </div>
    </div>
    <div id="chart-bar-m3" class="col-md-8">

    <?php 
        $label=[];
        $data=[];
        $color=[];
        foreach ($materiales as $m) {
            if ($m['m3']==0) {
                continue;
            }
            array_push($label, $m["nombre"]);
            array_push($data, $m["m3"]);
            array_push($color,'#'.dechex(rand(0x000000, 0xFFFFFF))) ;
        }
        
     ?>
     <div class="panel panel-primary">
        <div class="panel-heading"><strong>Gráfico</strong></div>
        <div class="panel-body">
            <?= ChartJs::widget([
                'type' => 'doughnut',
                'options' => [
                    'id'=>'matChart',
                    'height' => 300,
                    'width' => 400,
                    
                ],

                'data' => [
                    'labels' => $label,
                    'datasets' => [
                        [
                            'backgroundColor' => $color,
                            'borderColor' => "rgba(179,181,198,1)",
                            'data' => $data
                        ],
                        
                    ]
                ]
            ]);
            ?>
        </div>
      </div>
    </div>
    
        <img id="imgChartM3" src="" height="500" width="700" style="display: none;">
    
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
    function printM3()
    {
      var canvas = document.getElementById("matChart");
      var chart=document.getElementById("chart-bar-m3").style.display="none";  
      var img= canvas.toDataURL("image/png");
      var elem = document.getElementById("imgChartM3");
      elem.setAttribute("src", img);
      elem.style.display="inline";

      
      setTimeout(function() {
        var imprimir = document.getElementById("m3-grid").outerHTML;
        var print=document.getElementById("section-to-print");
        print.innerHTML = imprimir;
        window.print();
        print.innerHTML = "";
        elem.style.display="none";
        document.getElementById("chart-bar-m3").style.display="block";
      }, 500);

      
    }

</script>