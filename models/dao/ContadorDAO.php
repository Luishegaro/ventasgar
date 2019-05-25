<?php

namespace app\models\dao;

use Yii;
use yii\db\mssql\PDO;
use app\models\Contador;

class ContadorDAO extends \yii\base\Object{

  public function countById($tabla,$primary,$id,$id_valor){
    return Yii::$app->db->createCommand("
      SELECT COUNT(:PRIMARY)
      FROM $tabla
      WHERE _estado='A' AND $id=:ID_VALOR
    ")->bindValue(':PRIMARY', $primary)
    ->bindValue(':ID_VALOR', $id_valor)
    ->queryScalar();
  }

}