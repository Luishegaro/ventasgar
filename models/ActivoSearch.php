<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activo;

/**
 * ActivoSearch represents the model behind the search form about `app\models\Activo`.
 */
class ActivoSearch extends Activo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_activo'], 'integer'],
            [['codigo', 'detalle', 'foto', 'cuenta', '_registrado', '_usuario', '_estado'], 'safe'],
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
    public function search($params)
    {
        $query = Activo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_activo' => $this->id_activo,
            '_registrado' => $this->_registrado,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'detalle', $this->detalle])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'cuenta', $this->cuenta])
            ->andFilterWhere(['like', '_usuario', $this->_usuario])
            ->andFilterWhere(['like', '_estado', $this->_estado]);

        return $dataProvider;
    }
}
