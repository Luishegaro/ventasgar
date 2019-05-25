<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="container-fluid">
	<div class="row">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        
    ]); ?>
    <div class="col-md-6">
    	<div class="row">
	      <div class="col-xs-12">
	        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label("Usuario") ?>
	      </div>
	      <div class="col-xs-12">
	        <?= $form->field($model, 'password')->passwordInput()->label("Contraseña") ?>
	        <?= $form->field($model, 'rememberMe')->checkbox([])->label('No cerrar sesión') ?>
	      </div>
	      
	    </div>
        
    </div>
    

        <div class="form-group">
            <div class="col-md-offset-2 col-md-6">
                <?= Html::submitButton('Iniciar Sesión', ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
	</div>
    
</div>
