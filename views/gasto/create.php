<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Adelanto */

$this->title = 'Crear Gasto';
$this->params['breadcrumbs']=null;
?>
<h3 class="text-center"><?= Html::encode($this->title) ?></h3>
    <div class="adelanto-create">
        <!--['layout' => 'horizontal']-->
        <?php $form = ActiveForm::begin(); ?>
    	    <?= $this->render('_form', [
    	        'model' => $model,
    	        'form'=>$form,
    	        'activo'=>true,
    	    ]) ?>
    	    <div class="form-group text-right">
            <?= Html::submitButton('Guardar', ['id'=>'subcli','class' => 'btn btn-success', 'name' => 'cliente-button',]) ?>
          </div>
    	<?php ActiveForm::end();?>
    <?php 
          Modal::begin([
              'header'=>'<h4>Datos Activo</h4>',
              'id'=>'modal',
              'size'=>'modal-lg',
            ]);
          echo "<div id='modalContent'></div>";
          Modal::end();
        ?>
    </div>
  <!--ventana create-->