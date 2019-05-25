<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use yii\web\View;
use kartik\select2\Select2;

$this->title = 'Reporte de Deudas Pendientes';
$this->params['breadcrumbs']=null;
?>
<?php $form = ActiveForm::begin([
        'action' => ['deuda'],
        'method' => 'get',

    ]); ?>
<h1><?= Html::encode($this->title)  ?> 
            <?= Html::submitButton('<i class="glyphicon glyphicon-print"></i> Generar Reporte', ['id'=>'btn-buscar','class' => 'btn btn-danger','formtarget'=>'_blank']) ?>
       </h1>
<div class="row">

    

    <div class="col-md-6">
        <label>Seleccione los clientes</label>
        <?php 
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $clientes,
                'key'=>'id_cliente',
                'pagination' => false
            ]);

          ?>
          <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\CheckboxColumn',
                'name'=>'Reporte[id_cliente]',
                ],
                [
                    'label'=>'Cliente',
                    'attribute'=>'nombre',
                ],
                [
                    'label'=>'Total Deudas Pendientes',
                    'attribute'=>'deudas',
                ],
            ],
        ]); ?>
    </div>
    <div class="col-md-6">
        <br>
        <br>
        
    </div> 
    
    <?php ActiveForm::end(); ?>
    
</div>
<?php   $this->registerJs("
jQuery('#checkAll').change(function(){jQuery('.client').prop('checked',this.checked?'checked':'');})");?>

