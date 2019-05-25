<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use app\models\Adelanto;
use yii\data\SqlDataProvider;

/**
 * AdelantoSearch represents the model behind the search form about `app\models\Adelanto`.
 */
class GastoSearch extends Gasto
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
    /*public function search($params)
    {

        $query = Adelanto::filter($params);

        // add conditions that should always apply here

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
        ]);
        
        

        return $dataProvider;
    }*/
    public function search($params) {
        isset($_GET['GastoSearch']['numero']) ? $numero = $_GET['GastoSearch']['numero'] : $numero = "";
        isset($_GET['GastoSearch']['nombre']) ? $nombre = $_GET['GastoSearch']['nombre'] : $nombre = "";
        isset($_GET['GastoSearch']['_estado']) ? $_estado = $_GET['GastoSearch']['_estado'] : $_estado = "";

        $totalCount = Yii::$app->db
                ->createCommand("SELECT COUNT(g.id_gasto) FROM gasto g WHERE g.id_gasto like :NUMERO and g.pagado_a like :NOMBRE AND g._estado LIKE :ESTADO")
                ->bindValue(':NUMERO', '%' . $numero . '%')
                ->bindValue(':NOMBRE', '%' . $nombre . '%')
                ->bindValue(':ESTADO', '%' . $_estado . '%')
                ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db' => Yii::$app->db,
            'sql' => "SELECT g.* FROM gasto g WHERE g.id_gasto like :NUMERO and g.pagado_a like :NOMBRE AND g._estado LIKE :ESTADO order by g.id_gasto DESC",
            'params' => [':NUMERO' => '%' . $numero . '%',':NOMBRE' => '%' . $nombre . '%',':ESTADO' => '%' . $_estado . '%'],
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $dataProvider;
    }
    
}
