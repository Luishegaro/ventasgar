<?php

namespace app\models\dao;

use Yii;
use yii\db\mssql\PDO;
use app\models\Venta;

class VentaDAO extends \yii\base\Object{

  public function delete(Venta $venta){
    return Yii::$app->db->createCommand()->update('venta',[
      '_estado' => $venta->_estado,
      ],['id_venta' => $venta->id_venta])->execute();
  }

  public function update(Venta $venta){
    $fecha=date_format(date_create($venta->fecha),"Y-m-d");
    return Yii::$app->db->createCommand()->update('venta',[
      'fecha' => $fecha,
      'cancelado' => $venta->cancelado,
      'numero' => $venta->numero,
      'saldo' => $venta->saldo,
      'id_cliente' => $venta->id_cliente,
      '_registrado' => $venta->_registrado,
      '_usuario' => $venta->_usuario,
      'observacion' => $venta->observacion,
      'tipo'=>$venta->tipo,
      'total'=>$venta->total,
    ],['id_venta' => $venta->id_venta])->execute();
  }


  public function create(Venta $venta){
    $fecha=date_format(date_create($venta->fecha),"Y-m-d");
    return Yii::$app->db->createCommand()->insert('venta',[
      'fecha' => $fecha,
      'cancelado' => $venta->cancelado,
      'numero' => $venta->numero,
      'saldo' => $venta->saldo,
      'id_cliente' => $venta->id_cliente,
      '_registrado' => $venta->_registrado,
      '_usuario' => $venta->_usuario,
      'tipo'=>$venta->tipo,
      'total'=>$venta->total,
      'observacion' => $venta->observacion,
    ])->execute();
  }

  public function getById($id_venta){
    return Yii::$app->db->createCommand("
      SELECT id_venta, numero,DATE_FORMAT(fecha,'%d-%m-%Y') as fecha,tipo,cancelado,total,saldo,id_cliente,_registrado,_usuario,_estado
      FROM venta
      WHERE id_venta = :ID
    ")->bindValue(':ID', $id_venta)
    ->queryOne();
  }
  
  public function getByIdView($id_venta){
    return Yii::$app->db->createCommand("
      SELECT r.tipo,c.nombre,c.placa,r.id_venta, r.numero,DATE_FORMAT(fecha,'%d-%m-%Y') as fecha, r.cancelado,r.id_cliente,r._registrado,r._usuario,r._estado ,r.total,r.saldo FROM venta r, cliente c WHERE r.id_cliente=c.id_cliente AND r.id_venta = :ID
    ")->bindValue(':ID', $id_venta)
    ->queryOne();
  }
/*********PARA REPORTES**********/
  public function getVentas($fecha){
    $fecha=date_format(date_create($fecha),"Y-m-d");
    return Yii::$app->db->createCommand("
      SELECT r._estado,r.fecha,r.numero,r.id_venta,c.nombre,r.tipo,r.cancelado,r.total,r.saldo
      FROM cliente c,venta r WHERE r.id_cliente=c.id_cliente AND r.fecha =:FECHA ORDER BY id_venta ASC
    ")->bindValue(':FECHA',$fecha)->queryAll();
  }
  public function getMateriales($fecha){
    $fecha=date_format(date_create($fecha),"Y-m-d");
    return Yii::$app->db->createCommand("
      SELECT m.id_material,m.nombre,sum(d.cantidad) as cantidad,sum(d.precio) as precio FROM detalle d,material m,venta v WHERE d.id_material=m.id_material AND d.id_venta=v.id_venta AND v._estado='A' AND v.fecha=:FECHA GROUP BY m.id_material
    ")->bindValue(':FECHA',$fecha)->queryAll();
  }
  public function getRecibos($fecha){
    $fecha=date_format(date_create($fecha),"Y-m-d");
    return Yii::$app->db->createCommand("
      SELECT p.*,c.nombre
      FROM pago p, cliente c WHERE p.id_cliente=c.id_cliente AND p.tipo=0 AND p._estado='A' AND p.fecha =:FECHA ORDER BY tipo DESC
    ")->bindValue(':FECHA',$fecha)->queryAll();
  }
  public function getGastos($fecha){
    $fecha=date_format(date_create($fecha),"Y-m-d");
    return Yii::$app->db->createCommand("
      SELECT g.*
      FROM gasto g WHERE g._estado='A' AND g.fecha =:FECHA ORDER BY id_gasto ASC
    ")->bindValue(':FECHA',$fecha)->queryAll();
  }
/*********PARA REPORTES**********/
  public function getVentasCredito(){
    return Yii::$app->db->createCommand("
      SELECT r.id_venta,r.numero,c.placa,c.nombre,DATE_FORMAT(r.fecha,'%d-%m-%Y') as fecha,p.id_pago,r.total,p.total_pagado,p.saldo,r._registrado,r._usuario
      FROM cliente c,venta r,pago p WHERE r.id_cliente=c.id_cliente AND r.id_venta=p.id_venta AND r._estado='A' AND p._estado='A' AND r.tipo=1 AND p.saldo<>0 AND p.actual=1 ORDER BY r.id_venta DESC
    ")->queryAll();
  }
  
  
  public function getLastInsertedId(){
    return Yii::$app->db->createCommand("
      SELECT max(id_venta) as id_venta
      FROM venta
    ")->queryScalar();
  }
  public function getTotalSaldo($id){
    return Yii::$app->db->createCommand("
      SELECT IFNULL(SUM(saldo),0) as deuda
      FROM venta
      WHERE _estado='A' AND id_cliente=:ID
    ")->bindValue(':ID', $id)
    ->queryScalar();
  }
  public function getVentaByIdCliente($id){
    return Yii::$app->db->createCommand("
      SELECT id_venta,numero,cancelado, fecha, total,IFNULL((SELECT SUM(monto)+venta.cancelado FROM pago WHERE pago.id_venta=venta.id_venta AND _estado='A'),0) as total_pagado,saldo
      FROM venta
      WHERE saldo <>0 AND _estado='A' AND id_cliente=:ID
    ")->bindValue(':ID', $id)
    ->queryAll();
  }
  public function countByIdCliente($id){
    return Yii::$app->db->createCommand("
      SELECT COUNT(id_venta)
      FROM venta
      WHERE _estado='A' AND id_cliente=:ID
    ")->bindValue(':ID', $id)
    ->queryScalar();
  }
  public function getVentasTotal()
  {
    return Yii::$app->db->createCommand("
      SELECT SUM(cancelado) as cancelado,SUM(total) as total
      FROM venta
      WHERE _estado='A'
    ")->queryOne();
  }

}