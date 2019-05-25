<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\MaterialForm;

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
        <?= Html::submitButton('Generar', ['class' => 'btn btn-primary','target'=>'_blank',]) ?>
        <?= Html::resetButton('Actualizar', ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>
    
    <?php echo $this->render('rpt-ventas', ['data' => $data]); ?>
</div>
</div>

    
