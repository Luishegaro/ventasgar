<?php

namespace app\models\dao;

use Yii;

use app\models\Reporte;

class ReporteDAO extends \yii\base\Object{

  public function getVentasByCliente(Reporte $reporte){
     return Yii::$app->db->createCommand("
      SELECT v.id_venta,v.fecha,v.numero,v.cancelado,v.total,v.saldo,v.id_cliente
      FROM venta v,cliente c WHERE v.id_cliente=c.id_cliente AND v.tipo=1 AND v.fecha BETWEEN :FECHA_INICIO AND :FECHA_FIN  AND v._estado='A' ORDER BY v.id_venta
    ")
     ->bindValue(':FECHA_INICIO', $reporte->fecha_inicio)
     ->bindValue(':FECHA_FIN', $reporte->fecha_fin)->queryAll();
  }

  
  public function getResumen(Reporte $reporte){
   return Yii::$app->db->createCommand("
      SELECT fecha,DATE_FORMAT(fecha,'%W') AS dia,(SELECT SUM(cancelado) from venta WHERE v.fecha=venta.fecha AND _estado='A') AS efectivo,IFNULL((SELECT SUM(total-cancelado) from venta WHERE v.fecha=venta.fecha AND tipo=1 AND _estado='A'),0) AS credito,IFNULL((SELECT SUM(monto) FROM pago WHERE fecha=v.fecha AND tipo=0 AND _estado='A'),0) AS cobro,IFNULL((SELECT SUM(monto) FROM gasto WHERE fecha=v.fecha AND _estado='A'),0) AS gasto FROM venta v WHERE _estado='A' AND fecha BETWEEN :FECHA_INICIO AND :FECHA_FIN GROUP by fecha;
    ")
     ->bindValue(':FECHA_INICIO', $reporte->fecha_inicio)
     ->bindValue(':FECHA_FIN', $reporte->fecha_fin)->queryAll();
  }
  public function getResumenMateriales(Reporte $reporte){
   return Yii::$app->db->createCommand("
      SELECT m.id_material,m.nombre,IFNULL((SELECT SUM(d.cantidad) from detalle d, venta v where d.id_material=m.id_material and v.id_venta=d.id_venta AND v._estado='A' and v.fecha BETWEEN :FECHA_INICIO AND :FECHA_FIN),0) AS m3,IFNULL((SELECT SUM(d.precio) from detalle d, venta v where d.id_material=m.id_material and v.id_venta=d.id_venta AND v._estado='A' and v.fecha BETWEEN :FECHA_INICIO AND :FECHA_FIN),0) AS importe from material m
    ")
     ->bindValue(':FECHA_INICIO', $reporte->fecha_inicio)
     ->bindValue(':FECHA_FIN', $reporte->fecha_fin)->queryAll();
  }
  public function getMaterialByIdAndFecha($id,$fecha){
   return Yii::$app->db->createCommand("
      SELECT m.id_material,m.nombre, IFNULL(sum(d.cantidad),0) as cantidad, IFNULL(sum(d.precio),0) as precio FROM detalle d,material m,venta v WHERE d.id_material=m.id_material AND d.id_venta=v.id_venta AND v._estado='A' AND v.fecha=:FECHA AND m.id_material=:ID
    ")->bindValue(':FECHA',$fecha)->bindValue(':ID',$id)->queryOne();
  }
  /*public function getLastInsertedId(){
    return Yii::$app->db->createCommand("
      SELECT last_value as id
      FROM patrimonio_id_seq
    ")->queryOne();
  }*/

}