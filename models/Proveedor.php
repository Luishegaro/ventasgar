<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proveedor".
 *
 * @property string $id_proveedor
 * @property string $ci_nit
 * @property string $nombre
 * @property string $celular
 * @property string $direccion
 * @property string $_estado
 * @property string $_registrado
 * @property string $_usuario
 */
class Proveedor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proveedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', '_usuario'], 'required'],
            [['_registrado'], 'safe'],
            [['ci_nit'], 'integer'],
            [['nombre', '_usuario'], 'string', 'max' => 64],
            [['celular'], 'string', 'max' => 20],
            [['direccion'], 'string', 'max' => 200],
            [['_estado'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_proveedor' => 'Id Proveedor',
            'ci_nit' => 'Ci Nit',
            'nombre' => 'Nombre',
            'celular' => 'Celular',
            'direccion' => 'Direccion',
            '_estado' => 'Estado',
            '_registrado' => 'Registrado',
            '_usuario' => 'Usuario',
        ];
    }
}
