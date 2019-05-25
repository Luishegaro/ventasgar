<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use app\models\ClienteForm;

/**
 * CliSearch represents the model behind the search form about `app\models\Cli`.
 */
class ClienteSearch extends ClienteForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cliente', '_usuario'], 'integer'],
            [['placa', 'nombre', 'telefono', 'direccion', '_registrado'], 'safe'],
            [['deuda'], 'number'],
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
    public function search($params) {
        isset($_GET['ClienteSearch']['placa']) ? $placa = $_GET['ClienteSearch']['placa'] : $placa = "";
        isset($_GET['ClienteSearch']['nombre']) ? $nombre = $_GET['ClienteSearch']['nombre'] : $nombre = "";

        $totalCount = Yii::$app->db
                ->createCommand("SELECT COUNT(id_cliente) FROM cliente WHERE placa like :PLACA AND nombre like :NOMBRE ")
                ->bindValue(':PLACA', '%' . $placa . '%')
                ->bindValue(':NOMBRE', '%' . $nombre . '%')
                ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'db' => Yii::$app->db,
            'sql' => "SELECT * FROM cliente WHERE placa like :PLACA AND nombre like :NOMBRE ORDER BY id_cliente DESC",
            'params' => [':PLACA' => '%' . $placa . '%',':NOMBRE' => '%' . $nombre . '%'],
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $dataProvider;
    }
}
