<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\ClienteForm;
use app\models\Activo;
use app\components\PTotal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AdelantoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'RECIBOS DE GASTO';
$this->params['breadcrumbs']=null;
?>
<div class="adelanto-index">
    <h3 class="text-center"><?= Html::encode($this->title) ?></h3>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <!--<p>
        <?= Html::a('Crear Gasto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->
        <div class="table-responsive">  
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'showFooter' => true,
                    'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline'],
                    'rowOptions'=>function($model){
                          if ($model["_estado"]=='X') {
                            return ['class'=>'danger'];
                          }
                      },
                    'columns' => [
                        
                        [
                            'label'=>'Nro.',
                            'attribute'=>'id_gasto',
                        ],
                        [
                            'attribute'=>'fecha',
                            'format'=> ['date', 'php:D, d/m/Y']
                        ],
                        [
                            'label'=>'Pagado a',
                            'attribute'=>'pagado_a',
                        ],
                        [
                            'label'=>'Nro. Factura/Recibo',
                            'attribute'=>'nro_factura',
                        ],
                        [
                            'label'=>'Tipo',
                            'attribute'=>'tipo',
                            
                        ],
                        'concepto:ntext',
                        [
                            'label'=>'Activo',
                            'attribute'=>'id_activo',
                            'value'=>function ($model)
                            {
                                $activo=Activo::findOne($model["id_activo"]);
                                return (isset($activo))?$activo->detalle:null;
                            },
                            
                        ],
                        [
                        'attribute' => 'monto',
                        'contentOptions' => ['class' => 'text-right'],
                        'footer'=>Yii::$app->formatter->asDecimal(PTotal::pageTotal($dataProvider->getModels(),'monto'),2),
                        'footerOptions' => ['class' => 'text-right'],
                      ],
                        [
                            'attribute'=>'_registrado',
                            'format'=> ['date', 'php:d/m/Y H:m:s']
                          ],
                        '_usuario',
                        [
                            'label'=>'Estado',
                            'attribute'=>'_estado',
                            'value'=>function($model){
                                switch ($model["_estado"]) {
                                    case 'A':
                                        return "Activo";
                                        break;
                                    case 'X':
                                        return "Anulada";
                                        break;
                                }
                            }
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',

                          'buttons' => [

                            'view' => function($url, $model, $key){
                              $url = ['view', 'id' => $model['id_gasto']];
                              return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'Ver'),
                                'class'=>'btn btn-sm btn-primary',
                                'style'=>'margin-bottom:10px',
                                ]);
                            },

                            'update' => function($url, $model, $key){
                              $url = ['update', 'id' => $model['id_gasto']];
                              return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'Modificar'),
                                'class'=>'btn btn-sm btn-warning',
                                'style'=>'margin-bottom:10px',
                                ]);
                            },

                            'delete' => function($url, $model, $key){
                              $url = ['delete', 'id' => $model['id_gasto']];
                              if ($model['_estado']=='A') {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'Eliminar'),
                                'data-confirm' => Yii::t('app', 'Esta seguro de elimnar este item?'),
                                'class'=>'btn btn-sm btn-danger',
                                'style'=>'margin-bottom:10px',
                                ]);
                              }
                              else
                              {
                                return Html::a('<span class="glyphicon glyphicon-repeat"></span>', $url, [
                                'title' => Yii::t('app', 'Reestablecer'),
                                'class'=>'btn btn-sm btn-info',
                                'data-confirm' => Yii::t('app', 'Esta seguro de reestablecer este item?'),
                                ]);
                              }
                            },
                          ],
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

