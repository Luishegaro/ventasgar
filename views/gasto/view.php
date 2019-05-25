<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Activo;

/* @var $this yii\web\View */
/* @var $model app\models\Adelanto */

$this->title = 'RECIBO DE GASTO NRO. '. $model->id_gasto;
$this->params['breadcrumbs']=null;
?>
<div class="adelanto-view" style="margin-top: 10px;">
    <div class="col-md-4 col-md-offset-3" >
        <div class="panel panel-default">
        <h5 class="text-center">RECIBO DE GASTO <br>NRO.<?= $model->id_gasto?></h5>
        <div class="panel-body">
            <P style="margin-bottom: 0px"> <strong>Fecha :</strong> <?=$model->fecha?></P>
            <P style="margin-bottom: 0px"> <strong>Pagado a :</strong> <?=$model->pagado_a?></P>
            <P style="margin-bottom: 0px"> <strong>Pagado por : </strong><?=$model->_usuario?></P>
        
             <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label'=>'Activo',
                        'attribute'=>'id_activo',
                        'value'=>function ($model)
                        {
                            $activo=Activo::findOne($model["id_activo"]);
                            return (isset($activo))?$activo->detalle:null;
                        },
                    ],
                ],
            ]) ?>
            <hr>
            <P style="margin-bottom: 0px"> <strong>Registrado : </strong><?=$model->_registrado?></P>
            <P style="margin-bottom: 0px"> <strong>Nro Factura/Recibo : </strong><?=$model->nro_factura?></P>
            <P style="margin-bottom: 0px"> <strong>Tipo de gasto : </strong><?=$model->tipo?></P>

            <div class="row">
                <div class="panel-body">
                    <strong> Concepto : </strong><?=$model->concepto?><br>
                    <strong> Cancelado : </strong><?=$model->monto?>
                </div>
            </div>
          <!--  <P style="margin-bottom: 0px"> <strong>Concepto : </strong><?=$model->concepto?></P>
            <P style="margin-bottom: 0px"> <strong>Cancelado : </strong><?=$model->monto?></P>-->
            
            
   <!-- <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha',
            [
            'attribute'=>'pagado_a',
            'label'  => 'Pagado a',
            ],
            [
            'attribute'=>'nro_factura',
            'label'  => 'Nro Factura/Recibo',
            ],
            [
            'attribute'=>'tipo',
            'label'  => 'Tipo de Gasto',
            ],
            'concepto:ntext',
            [
                'label'=>'Activo',
                'attribute'=>'id_activo',
                'value'=>function ($model)
                {
                    $activo=Activo::findOne($model["id_activo"]);
                    return (isset($activo))?$activo->detalle:null;
                },
                
            ],
            'monto',
            
            '_registrado',
            '_usuario',
        ],
    ]) ?>-->
        </div>
      </div>
    </div>
    <div class="col-md-2">
        <?=
             Html::a('<i class="glyphicon glyphicon-print"></i> Imprimir Recibo', '#', [
              'class'=>'btn btn-danger btn-block',
              'data-toggle'=>'tooltip', 
              'title'=>'Abrira una Ventana de impresión',
              'onclick'=>'imprimirGasto()'
          ]);
          ?>
          <br>
    <?= Html::a('Modificar', ['update', 'id' => $model->id_gasto], ['class' => 'btn btn-primary btn-block']) ?>
    <br>
    <?= Html::a('Eliminar', ['delete', 'id' => $model->id_gasto], [
        'class' => 'btn btn-danger btn-block',
        'data' => [
            'confirm' => 'Estas seguro de eliminar este item?',
            'method' => 'post',
        ],
    ]) ?>
    </div>
</div>
<script type="text/javascript">
    function load() {
      printJS('../web/pdfs/gasto.pdf');
    }
    window.onload = load;
    function imprimirGasto(){
      printJS('../web/pdfs/gasto.pdf');
    }
</script>
