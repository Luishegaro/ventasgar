<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use app\models\PagoForm;
use yii\data\SqlDataProvider;

/**
 * AdelantoSearch represents the model behind the search form about `app\models\Adelanto`.
 */
class PagoSearch extends PagoForm
{
    /**
     * @inheritdoc
     */
    public $nombre;
    public function rules()
    {
        return [
            
            [['nombre','numero'], 'safe'],
            [['numero'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    public function searchLista($params) {
        isset($_GET['PagoSearch']['numero']) ? $numero = $_GET['PagoSearch']['numero'] : $numero = "";
        isset($_GET['PagoSearch']['nombre']) ? $nombre = $_GET['PagoSearch']['nombre'] : $nombre = "";
        isset($_GET['PagoSearch']['_estado']) ? $_estado = $_GET['PagoSearch']['_estado'] : $_estado = "A";

        $totalCount = Yii::$app->db
                ->createCommand("SELECT COUNT(p.id_pago) FROM pago p,cliente c WHERE p.id_cliente=c.id_cliente AND p.tipo=0 AND p.id_pago like :NUMERO and c.nombre like :NOMBRE AND p._estado like :ESTADO")
                ->bindValue(':NUMERO', '%' . $numero . '%')
                ->bindValue(':NOMBRE', '%' . $nombre . '%')
                ->bindValue(':ESTADO', '%'. $_estado .'%')
                ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db' => Yii::$app->db,
            'sql' => "SELECT p.*,c.nombre,c.placa FROM pago p,cliente c WHERE c.id_cliente=p.id_cliente AND p.tipo=0 AND p.id_pago like :NUMERO and c.nombre like :NOMBRE AND p._estado like :ESTADO order by p.id_pago DESC",
            'params' => [':NUMERO' => '%' . $numero . '%',':NOMBRE' => '%' . $nombre . '%',':ESTADO' => '%'.$_estado .'%'],
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $dataProvider;
    }
    
    public function search($params) {
        isset($_GET['PagoSearch']['numero']) ? $numero = $_GET['PagoSearch']['numero'] : $numero = "";
        isset($_GET['PagoSearch']['nombre']) ? $nombre = $_GET['PagoSearch']['nombre'] : $nombre = "";

        $totalCount = Yii::$app->db
                ->createCommand("SELECT COUNT(r.id_venta) FROM cliente c,venta r WHERE r.id_cliente=c.id_cliente AND r._estado='A' AND r.saldo<>0 AND c.nombre like :NOMBRE AND r.id_venta like :NUMERO")
                ->bindValue(':NUMERO', '%' . $numero . '%')
                ->bindValue(':NOMBRE', '%' . $nombre . '%')
                ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db' => Yii::$app->db,
            'sql' => "SELECT r.id_venta,r.numero,c.placa,c.nombre,DATE_FORMAT(r.fecha,'%d-%m-%Y') as fecha,r.total,(r.cancelado+IFNULL((SELECT SUM(monto) FROM pago WHERE id_venta=r.id_venta AND _estado='A'),0)) as total_pagado,r.saldo,r._registrado,r._usuario
                    FROM cliente c,venta r WHERE r.id_cliente=c.id_cliente AND r._estado='A' AND r.saldo<>0 AND c.nombre like :NOMBRE AND r.id_venta like :NUMERO ORDER BY r.id_venta DESC",
            'params' => [':NUMERO' => '%' . $numero . '%',':NOMBRE' => '%' . $nombre . '%'],
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $dataProvider;
    }
}
