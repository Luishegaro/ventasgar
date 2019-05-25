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

$this->title = 'Reporte de Ingresos';
$this->params['breadcrumbs']=null;
?>

<div class="row">

    <?php $form = ActiveForm::begin([
        'action' => ['ingreso'],
        'method' => 'get',

    ]); ?>

    <div class="col-md-6 col-md-offset-3">
        <label>Rango de fechas:</label>
        <?php
            echo DatePicker::widget([
                'model' => $model,
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
            <?= Html::submitButton('Generar Reporte', ['id'=>'btn-buscar','class' => 'btn btn-primary',]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Materiales M3</a></li>
            <li><a data-toggle="tab" href="#menu1">Materiales Importe</a></li>
            <li><a data-toggle="tab" href="#menu2">Resumen</a></li>
            <li><a data-toggle="tab" href="#menu3">Gráfico M3</a></li>
            <li><a data-toggle="tab" href="#menu4">Gráfico Importe</a></li>
        </ul>
        <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <?php if (isset($materiales)): ?>
              <?= $this->render('_materiales-m3', [
                    'model' => $model,
                    'materiales' => $materiales,
                ]) ?>
          <?php endif ?>
          
        </div>
        <div id="menu1" class="tab-pane fade">
          <?php if (isset($materiales)): ?>
              <?= $this->render('_materiales-importe', [
                    'model' => $model,
                    'materiales' => $materiales,
                ]) ?>
          <?php endif ?>
        </div>
        <div id="menu2" class="tab-pane fade">
            <?php if (isset($resumen)): ?>
              <?= $this->render('_ventas', [
                    'model' => $model,
                    'resumen' => $resumen,
                ]) ?>
          <?php endif ?>
        </div>
        <div id="menu3" class="tab-pane fade">
            <?php if (isset($resumen)): ?>
              <?= $this->render('_m3-grafico', [
                    'model' => $model,
                    'resumen' => $resumen,
                    'materiales' => $materiales,
                ]) ?>
          <?php endif ?>
        </div>
        <div id="menu4" class="tab-pane fade">
            <?php if (isset($resumen)): ?>
              <?= $this->render('_importe-grafico', [
                    'model' => $model,
                    'resumen' => $resumen,
                    'materiales' => $materiales,
                ]) ?>
          <?php endif ?>
        </div>
      </div>
    </div>
</div>
<div id="section-to-print">
    
</div>




