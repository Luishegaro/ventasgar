<?php

namespace app\models\dao;

use Yii;
use yii\db\mssql\PDO;
use app\models\DetalleForm;

class DetalleDAO extends \yii\base\Object{

  /*public function delete(ClienteForm $cliente){
    return Yii::$app->db->createCommand()->delete('cliente',
      ['id_cliente' => $cliente->id_cliente])->execute();
  }*/

  /*public function update(ClienteForm $cliente){
    return Yii::$app->db->createCommand()->update('cliente',[
      'nombre' => strtoupper($cliente->nombre),
      'placa' => strtoupper($cliente->placa),
      'direccion' => strtoupper($cliente->direccion),
      'telefono' => $cliente->telefono,
      'deuda' => $cliente->deuda,
      '_registrado' => $cliente->_registrado,
      '_usuario' => $cliente->_usuario,
    ],['id_cliente' => $cliente->id_cliente])->execute();
  }*/


  public function create(DetalleForm $detalle){
   
    return Yii::$app->db->createCommand()->insert('detalle',[
      'id_venta' => $detalle->id_venta,
      'id_material' => $detalle->id_material,
      'cantidad' => $detalle->cantidad,
      'precio' => $detalle->precio,
    ])->execute();
  }
  public function deleteByIdVenta($id){
    return Yii::$app->db->createCommand()->delete('detalle',
      ['id_venta' => $id])->execute();
  }

  public function getByIdVenta($id){
    return Yii::$app->db->createCommand("
      SELECT *
      FROM detalle
      WHERE id_venta = :ID
    ")->bindValue(':ID', $id)
    ->queryAll();
  }
  public function getByIdVentaView($id){
    return Yii::$app->db->createCommand("
      SELECT m.id_material,d.cantidad,m.nombre,m.precio,d.precio as costo FROM material m,detalle d where m.id_material=d.id_material and d.id_venta=:ID order by m.id_material desc;
    ")->bindValue(':ID', $id)->queryAll();
    
  }
  public function countById($id){
    return Yii::$app->db->createCommand("
      SELECT COUNT(id_material)
      FROM detalle
      WHERE id_material=:ID
    ")->bindValue(':ID', $id)
    ->queryScalar();
  }
}