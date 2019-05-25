<?php

namespace app\models\dao;

use Yii;

use app\models\Gasto;

class GastoDAO extends \yii\base\Object{

  public function delete(Gasto $gasto){
    return Yii::$app->db->createCommand()->update('gasto',[
      '_estado' =>$gasto->_estado,
    ],['id_gasto' => $gasto->id_gasto])->execute();
  }
  
  public function update(Gasto $gasto){
    $fecha=date_format(date_create($gasto->fecha),"Y-m-d");
    return Yii::$app->db->createCommand()->update('gasto',[
      'fecha' => $fecha,
      'pagado_a' => $gasto->pagado_a,
      'concepto' => $gasto->concepto,
      'monto' => $gasto->monto,
      'nro_factura' =>$gasto->nro_factura,
      'tipo'=>$gasto->tipo,
      'id_activo'=>$gasto->id_activo,
      'observacion'=>$gasto->observacion,
      '_registrado' =>$gasto->_registrado,
      '_usuario' =>$gasto->_usuario,
    ],['id_gasto' => $gasto->id_gasto])->execute();
  }

  public function create(Gasto $gasto){
    $fecha=date_format(date_create($gasto->fecha),"Y-m-d");
    return Yii::$app->db->createCommand()->insert('gasto',[
      'fecha' => $fecha,
      'pagado_a' => $gasto->pagado_a,
      'concepto' => $gasto->concepto,
      'monto' => $gasto->monto,
      'nro_factura' =>$gasto->nro_factura,
      'tipo'=>$gasto->tipo,
      'id_activo'=>$gasto->id_activo,
      'observacion'=>$gasto->observacion,
      '_registrado' =>$gasto->_registrado,
      '_usuario' =>$gasto->_usuario,
    ])->execute();
  }
  
  public function getLastInsertedId(){
    return Yii::$app->db->createCommand("
      SELECT max(id_gasto) as id_gasto
      FROM gasto
    ")->queryScalar();
  }
  
  public function getById($id_gasto){
    return Yii::$app->db->createCommand("
      SELECT *
      FROM  gasto 
      WHERE id_gasto = :ID
    ")->bindValue(':ID', $id_gasto)
    ->queryOne();
  }
}