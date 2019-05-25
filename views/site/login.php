<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar Sesión';
$this->params['breadcrumbs'] = null;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
          <div class="col-md-6">
            <div class="square-service-block btn-success">
                <div id="formVentas" class="hidden">
                    <?= $this->render('_form-login', [
                        'model' => $model,
                    ]) ?>
                </div>
                <div id="lblVentas">
                   <a id="btnVentas" href="#" onclick="setForm(this.id)">
                     <div class="ssb-icon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></div>
                     <h2 class="ssb-title">Ventas</h2>  
                   </a>
                </div>
                <br>
            </div>
          </div>
          <div class="col-md-6">
            <div class="square-service-block btn-primary">
                <div id="formAdmin" class="hidden">
                    <?= $this->render('_form-login', [
                        'model' => $model,
                    ]) ?>
                </div>
                <div id="lblAdmin">
                   <a id="btnAdmin" href="#" onclick="setForm(this.id)">
                     <div class="ssb-icon"> <i class="glyphicon glyphicon-cog" aria-hidden="true"></i> </div>
                     <h2 class="ssb-title">Administrador</h2>  
                   </a>
               </div>
               <br>
            </div>

          </div>
    </div>
    <div class="row">
          
    </div>
</div>
<script type="text/javascript">
    function setForm(val) {
        if (val=="btnVentas") {
            document.getElementById("lblAdmin").classList.remove("hidden");
            document.getElementById("formAdmin").classList.add("hidden");
            document.getElementById("lblVentas").classList.add("hidden");
            document.getElementById("formVentas").classList.remove("hidden");
        }
        else{
            document.getElementById("lblAdmin").classList.add("hidden");
            document.getElementById("formAdmin").classList.remove("hidden");
            document.getElementById("lblVentas").classList.remove("hidden");
            document.getElementById("formVentas").classList.add("hidden");
        }
        
    }
</script>
