<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cli */

$this->title = 'Create Cli';
$this->params['breadcrumbs'][] = ['label' => 'Clis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cli-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
