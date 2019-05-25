<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ParametroForm */

$this->title = 'Modificar Recibo de Cobro';
$this->params['breadcrumbs'] = null;
?>
<div class="row">
			<div class="cobro-form-update">
				<h3 class="text-center" ><?= Html::encode($this->title) ?></h3>
			    <?= $this->render('_form', [
			        'model' => $model,
			        'venta'=>$venta,
			    ]) ?>
			    </div>
</div>