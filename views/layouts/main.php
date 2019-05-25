<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Ventas Garzon',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
        'innerContainerOptions' => ['class' => 'container-fluid'],
    ]);
    if(Yii::$app->user->isGuest){
      echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                        ['label' => 'Iniciar Sesión', 'url' => ['/site/login']],
                ],
            ]);
        NavBar::end();
    }
    else{
      if (Yii::$app->user->identity->rol=='VENTAS') {
        echo Nav::widget([
          'options' => ['class' => 'navbar-nav navbar-right'],
          'items' => [
              ['label' => 'Nuevo Venta', 'url' => ['/admin-venta/principal']],
              ['label' => 'Nuevo Cobro', 'url' => ['/admin-pago/create-recibo']],
              ['label' => 'Nuevo Gasto', 'url' => ['/gasto/create']],
              ['label' => 'Deudas', 'url' => ['/admin-pago/index']], 
              ['label' => 'Historial Ventas', 'url' => ['/admin-venta/lista']],
              ['label' => 'Historial Cobros', 'url' => ['/admin-pago/lista']],
              ['label' => 'Historial Gastos', 'url' => ['/gasto/index']],
              ['label' => 'Arqueo de Caja', 'url' => ['/admin-venta/rpt-diario']],
    
              Yii::$app->user->isGuest ? (
                  ['label' => 'Iniciar Sesión', 'url' => ['/site/login']]
              ) : (
                  '<li>'
                  . Html::beginForm(['/site/logout'], 'post')
                  . Html::submitButton(
                      'Cerrar Sesión (' . Yii::$app->user->identity->username . ')',
                      ['class' => 'btn btn-link logout']
                  )
                  . Html::endForm()
                  . '</li>'
              )
          ],
      ]);
      NavBar::end();
      }
      else{
        echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Inicio', 'url' => ['/site/index']],
            
            [
              'label' => 'Recursos',
              'items' => [
                   ['label' => 'Clientes', 'url' => ['/admin-cliente/index']],
                   ['label' => 'Material', 'url' => ['/admin-material/index']],
                   ['label' => 'Proveedores', 'url' => ['/proveedor/index']],
                   ['label' => 'Activos', 'url' => ['/activo/index']],
                   
              ],
            ],
            [
              'label' => 'Ventas',
              'items' => [
              
                   ['label' => 'Nota de Venta', 'url' => ['/admin-venta/index']],
                   ['label' => 'Punto Venta', 'url' => ['/admin-venta/principal']],
                   ['label' => 'Lista de Ventas', 'url' => ['/admin-venta/lista']],
                   ['label' => 'Pagos', 'url' => ['/admin-pago/index']],
                   
              ],
            ],
            [
              'label' => 'Recibo',
              'items' => [
                ['label' => 'Recibos de Cobro', 'url' => ['/admin-pago/lista']],
                ['label' => 'Recibos de Gastos', 'url' => ['/gasto/index']],
                
              ],
            ],
            [
              'label' => 'Reportes',
              'items' => [
                ['label' => 'Arqueo de Caja', 'url' => ['/admin-venta/rpt-ventas']],
                ['label' => 'Reporte de Ingreso y Gastos', 'url' => ['/reporte/ingreso']],
                ['label' => 'Reporte Deudores', 'url' => ['/reporte/deuda']],
                
              ],
            ],
            [
              'label' => 'Sistema',
              'items' => [
                   
                   ['label' => 'Usuarios', 'url' => ['/rbac/index']],
              ],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Iniciar Sesión', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Cerrar Sesión (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
      }
      
    }
    
    ?>

    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Aridos Garzón <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
