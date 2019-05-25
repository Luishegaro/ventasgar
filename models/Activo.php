<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activo".
 *
 * @property integer $id_activo
 * @property string $codigo
 * @property string $detalle
 * @property string $foto
 * @property string $cuenta
 * @property string $_registrado
 * @property string $_usuario
 * @property string $_estado
 *
 * @property Gasto[] $gastos
 */
class Activo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'detalle', '_usuario','cuenta'], 'required'],
            [['cuenta'], 'string'],
            [['_registrado'], 'safe'],
            [['codigo'], 'string', 'max' => 15],
            [['_usuario'], 'string', 'max' => 64],
            [['foto'], 'string', 'max' => 100],
            [['_estado'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_activo' => 'Id Activo',
            'codigo' => 'Codigo',
            'detalle' => 'Detalle',
            'foto' => 'Foto',
            'cuenta' => 'Cuenta',
            '_registrado' => 'Registrado',
            '_usuario' => 'Usuario',
            '_estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGastos()
    {
        return $this->hasMany(Gasto::className(), ['id_activo' => 'id_activo']);
    }
}
