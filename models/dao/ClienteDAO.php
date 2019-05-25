<?php

namespace app\models\dao;

use Yii;

use app\models\ClienteForm;

class ClienteDAO extends \yii\base\Object{

  public function delete(ClienteForm $cliente){
    return Yii::$app->db->createCommand()->update('cliente',[
      '_estado' =>'X',
    ],['id_cliente' => $cliente->id_cliente])->execute();
  }

  public function update(ClienteForm $cliente){
    return Yii::$app->db->createCommand()->update('cliente',[
      'nombre' => strtoupper($cliente->nombre),
      'placa' => strtoupper($cliente->placa),
      'direccion' => strtoupper($cliente->direccion),
      'telefono' => $cliente->telefono,
      'deuda' => $cliente->deuda,
      '_registrado' => $cliente->_registrado,
      '_usuario' => $cliente->_usuario,
      '_estado' => $cliente->_estado,
    ],['id_cliente' => $cliente->id_cliente])->execute();
  }

  public function create(ClienteForm $cliente){
    return Yii::$app->db->createCommand()->insert('cliente',[
      'nombre' => strtoupper($cliente->nombre),
      'placa' => strtoupper($cliente->placa),
      'direccion' => strtoupper($cliente->direccion),
      'telefono' => $cliente->telefono,
      'deuda' => $cliente->deuda,
      '_registrado' => $cliente->_registrado,
      '_usuario' => $cliente->_usuario,
      '_estado' => $cliente->_estado,
      
    ])->execute();
  }

  public function getById($id){
    return Yii::$app->db->createCommand("
      SELECT *
      FROM cliente
      WHERE id_cliente = :ID
    ")->bindValue(':ID', $id)
    ->queryOne();
  }

  
  public function getAll(){
    return Yii::$app->db->createCommand("
      SELECT *
      FROM cliente ORDER BY id_cliente desc
    ")->queryAll();
  }
  public function getClientesConDeuda(){
     return Yii::$app->db->createCommand("
      SELECT c.id_cliente,c.nombre,COUNT(id_venta) as deudas 
      FROM cliente c,venta v WHERE c.id_cliente=v.id_cliente AND v.tipo=1 AND v.saldo<>0 group by v.id_cliente order by c.nombre Asc
    ")->queryAll();
  }
  public function getLista(){
    return Yii::$app->db->createCommand("
      SELECT *
      FROM cliente WHERE _estado='A' ORDER BY id_cliente desc
    ")->queryAll();
  }
  /*public function getLastInsertedId(){
    return Yii::$app->db->createCommand("
      SELECT last_value as id
      FROM patrimonio_id_seq
    ")->queryOne();
  }*/

}