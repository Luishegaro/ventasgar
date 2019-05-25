<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use app\models\Venta;
use yii\data\SqlDataProvider;
use app\models\dao\DAOFactory;

/**
 * AdelantoSearch represents the model behind the search form about `app\models\Adelanto`.
 */
class VentaSearch extends Venta
{
    /**
     * @inheritdoc
     */
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;
    public function rules()
    {
        return [
            [['numero'], 'integer'],
            [['fecha_inicio','fecha_inicio'], 'safe'],
            [['nombre','numero'], 'safe'],
            [['fecha_inicio','fecha_inicio'], 'date'],
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

   
    public function search($params) {
        isset($_GET['VentaSearch']['numero']) ? $numero = $_GET['VentaSearch']['numero'] : $numero = "";
        isset($_GET['VentaSearch']['nombre']) ? $nombre = $_GET['VentaSearch']['nombre'] : $nombre = "";
        isset($_GET['VentaSearch']['_estado']) ? $_estado = $_GET['VentaSearch']['_estado'] : $_estado = "A";
        isset($_GET['VentaSearch']['fecha_inicio']) ? $fecha_inicio = $_GET['VentaSearch']['fecha_inicio'] : $fecha_inicio = "";
        isset($_GET['VentaSearch']['fecha_fin']) ? $fecha_fin = $_GET['VentaSearch']['fecha_fin'] : $fecha_fin = "";
        $rango="";
        if ($fecha_inicio!="" and $fecha_fin!="") {
            $rango=" AND r.fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'";
        }
        

        $totalCount = Yii::$app->db
                ->createCommand("SELECT COUNT(r.id_venta) FROM cliente c,venta r WHERE r.id_cliente=c.id_cliente AND r.id_venta like :NUMERO AND c.nombre LIKE :NOMBRE AND r._estado LIKE :ESTADO ".$rango." ORDER BY id_venta DESC")
                ->bindValue(':NUMERO', '%' . $numero . '%')
                ->bindValue(':NOMBRE', '%' . $nombre . '%')
                ->bindValue(':ESTADO', '%' . $_estado . '%')
                ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db' => Yii::$app->db,
            'sql' => "SELECT * FROM cliente c,venta r WHERE r.id_cliente=c.id_cliente AND r.id_venta like :NUMERO AND c.nombre LIKE :NOMBRE AND r._estado LIKE :ESTADO ".$rango." ORDER BY id_venta DESC",
            'params' => [':NUMERO' => '%' . $numero . '%',':NOMBRE' => '%' . $nombre . '%',':ESTADO' => '%' . $_estado . '%'],
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $dataProvider;
    }
    public function get_rpt_ventas($params) {
        isset($_GET['VentaSearch']['fecha']) ? $fecha = $_GET['VentaSearch']['fecha'] : $fecha = "";
        
        return DAOFactory::getVentaDAO()->getVentas($fecha);
    }
    public function get_rpt_materiales($params) {
        isset($_GET['VentaSearch']['fecha']) ? $fecha = $_GET['VentaSearch']['fecha'] : $fecha = "";
        
        return DAOFactory::getVentaDAO()->getMateriales($fecha);
    }
    public function get_rpt_recibos($params) {
        isset($_GET['VentaSearch']['fecha']) ? $fecha = $_GET['VentaSearch']['fecha'] : $fecha = "";
        
        return DAOFactory::getVentaDAO()->getRecibos($fecha);
    }
    public function get_rpt_gastos($params) {
        isset($_GET['VentaSearch']['fecha']) ? $fecha = $_GET['VentaSearch']['fecha'] : $fecha = "";
        
        return DAOFactory::getVentaDAO()->getGastos($fecha);
    }
}
