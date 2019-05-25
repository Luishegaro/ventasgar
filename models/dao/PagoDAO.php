<?php

namespace app\models\dao;

use Yii;

use app\models\PagoForm;

class PagoDAO extends \yii\base\Object{

  public function delete(PagoForm $pago){
    return Yii::$app->db->createCommand()->update('pago',[
      '_estado' =>$pago->_estado,
    ],['id_pago' => $pago->id_pago])->execute();
  }
  public function deleteByIdVenta($id){
    return Yii::$app->db->createCommand()->delete('pago',
      ['id_venta' => $id])->execute();
  }

  public function update(PagoForm $pago){
    $fecha=date_format(date_create($pago->fecha),"Y-m-d");
    return Yii::$app->db->createCommand()->update('pago',[
      'fecha' => $fecha,
      'pagado_a' => $pago->pagado_a,
      'concepto' => $pago->concepto,
      'monto' => $pago->monto,
      'id_venta' =>$pago->id_venta,
      'id_cliente'=>$pago->id_cliente,
      '_registrado' =>$pago->_registrado,
      '_usuario' =>$pago->_usuario,
    ],['id_pago' => $pago->id_pago])->execute();
  }

  public function create(PagoForm $pago){
    $fecha=date_format(date_create($pago->fecha),"Y-m-d");
    return Yii::$app->db->createCommand()->insert('pago',[
      'fecha' => $fecha,
      'pagado_a' => $pago->pagado_a,
      'concepto' => $pago->concepto,
      'tipo' =>$pago->tipo,
      'monto' => $pago->monto,
      'id_venta' =>$pago->id_venta,
      'id_cliente'=>$pago->id_cliente,
      '_registrado' =>$pago->_registrado,
      '_usuario' =>$pago->_usuario,
    ])->execute();
  }
  public function createPrimer(PagoForm $pago){
    $fecha=date_format(date_create($pago->fecha),"Y-m-d");
    return Yii::$app->db->createCommand("CALL add_pago(:id_recibo, :fecha, :monto, :saldo, :usuario, :registrado)")
    ->bindValue(':id_recibo',$pago->id_recibo)
    ->bindValue(':fecha',$fecha)
    ->bindValue(':monto',$pago->monto)
    ->bindValue(':saldo',$pago->saldo)
    ->bindValue(':usuario',$pago->_usuario)
    ->bindValue(':registrado',$pago->_registrado)
    ->execute();
  }

  
  
  public function getLastInsertedId(){
    return Yii::$app->db->createCommand("
      SELECT max(id_pago) as id_pago
      FROM pago
    ")->queryScalar();
  }
  public function getTotalPagado($id){
    return Yii::$app->db->createCommand("
      SELECT SUM(monto)
      FROM pago 
      WHERE id_venta = :ID and _estado='A'
    ")->bindValue(':ID', $id)
    ->queryScalar();
  }
  public function getById($id_pago){
    return Yii::$app->db->createCommand("
      SELECT *
      FROM  pago 
      WHERE id_pago = :ID
    ")->bindValue(':ID', $id_pago)
    ->queryOne();
  }
  public function countByIdCliente($id){
    return Yii::$app->db->createCommand("
      SELECT COUNT(id_pago)
      FROM  pago 
      WHERE id_cliente = :ID AND _estado='A'
    ")->bindValue(':ID', $id)
    ->queryScalar();
  }
  public function getSaldoByIdCliente($id){
    return Yii::$app->db->createCommand("
      SELECT id_pago, fecha, concepto,monto
      FROM pago
      WHERE id_venta is NULL AND tipo=0 AND _estado='A' AND id_cliente=:ID
    ")->bindValue(':ID', $id)
    ->queryAll();
  }
  public function getPagosByIdVenta($id){
    return Yii::$app->db->createCommand("
      SELECT id_pago, fecha, concepto,monto
      FROM pago
      WHERE id_venta=:ID AND _estado='A'
    ")->bindValue(':ID', $id)
    ->queryAll();
  }
  
}