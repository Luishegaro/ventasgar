<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property integer $id_cliente
 * @property string $placa
 * @property string $nombre
 * @property string $telefono
 * @property string $direccion
 * @property double $deuda
 * @property string $_registrado
 * @property integer $_usuario
 *
 * @property Recibo[] $recibos
 */
class Cli extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['placa', 'nombre', '_usuario'], 'required'],
            [['deuda'], 'number'],
            [['_registrado'], 'safe'],
            [['_usuario'], 'integer'],
            [['placa', 'nombre'], 'string', 'max' => 100],
            [['telefono'], 'string', 'max' => 15],
            [['direccion'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cliente' => 'Id Cliente',
            'placa' => 'Placa',
            'nombre' => 'Nombre',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'deuda' => 'Deuda',
            '_registrado' => 'Registrado',
            '_usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibos()
    {
        return $this->hasMany(Recibo::className(), ['id_cliente' => 'id_cliente']);
    }
}
