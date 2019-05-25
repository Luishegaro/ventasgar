<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ParametroForm */

$this->title = 'Cobrando Saldo en Nota de Venta';
$this->params['breadcrumbs'] =null; 
?>
	<div class="cobro-form-create">
	    <h3 class="text-center"><?= Html::encode($this->title) ?></h3>
	    <?= $this->render('_form', [
	        'model' => $model,
	        'venta'=>$venta,
	    ]) ?>
	</div>