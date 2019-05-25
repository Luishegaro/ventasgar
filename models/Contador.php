<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\dao\DAOFactory;
/**
 * This is the model class for table "adelanto".
 *
 * @property integer $id_adelanto
 * @property string $numero
 * @property string $fecha
 * @property string $concepto
 * @property double $ingreso
 * @property integer $id_cliente
 * @property string $_registrado
 * @property string $_usuario
 * @property string $_estado
 *
 * @property Cliente $idCliente
 */
class Contador extends Model
{
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function countById($tabla,$primary,$id,$id_valor)
    {
        return DAOFactory::getContadorDAO()->countById($tabla,$primary,$id,$id_valor);
    }
    
}
