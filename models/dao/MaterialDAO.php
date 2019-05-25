<?php

namespace app\models\dao;

use Yii;

use app\models\MaterialForm;

class MaterialDAO extends \yii\base\Object{

  public function delete(MaterialForm $material){
    return Yii::$app->db->createCommand()->delete('material',
      ['id_material' => $material->id_material])->execute();
  }

  public function update(MaterialForm $material){
    return Yii::$app->db->createCommand()->update('material',[
      'nombre' => strtoupper($material->nombre),
      'precio' => $material->precio,
      '_registrado' => $material->_registrado,
      '_usuario' => $material->_usuario,
    ],['id_material' => $material->id_material])->execute();
  }


  public function create(MaterialForm $material){
    return Yii::$app->db->createCommand()->insert('material',[
      'nombre' => strtoupper($material->nombre),
      'precio' => $material->precio,
      '_registrado' => $material->_registrado,
      '_usuario' => $material->_usuario,
      
    ])->execute();
  }

  public function getById($id){
    return Yii::$app->db->createCommand("
      SELECT *
      FROM material
      WHERE id_material = :ID
    ")->bindValue(':ID', $id)
    ->queryOne();
  }

  
  public function getAll(){
    return Yii::$app->db->createCommand("
      SELECT *
      FROM material ORDER BY id_material asc
    ")->queryAll();
  }
  public function getByIdRecibo($id){
    return Yii::$app->db->createCommand("
      SELECT *,IFNULL((select d.precio from detalle d where d.id_material=m.id_material and d.id_venta=:ID),0) as costo ,IFNULL((select d.cantidad from detalle d where d.id_material=m.id_material and d.id_venta=:ID),0) as cantidad FROM material m order by id_material asc
    ")->bindValue(':ID', $id)->queryAll();
    
  }
  public function getCantidadByCliente($id){
    return Yii::$app->db->createCommand("
      SELECT IFNULL((SELECT SUM(cantidad) from detalle d, venta v WHERE d.id_venta=v.id_venta AND d.id_material=m.id_material AND v.id_cliente=:ID),0) as cantidad, id_material FROM material m WHERE id_material in (1,3)
    ")->bindValue(':ID', $id)->queryAll();
  }
  
  
  /*public function getLastInsertedId(){
    return Yii::$app->db->createCommand("
      SELECT last_value as id
      FROM patrimonio_id_seq
    ")->queryOne();
  }*/

}