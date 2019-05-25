<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\dao\DAOFactory;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class DetalleForm extends Model
{
    public $id_venta;
    public $id_material;
    public $cantidad;
    public $precio;
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id_venta','id_material','cantidad','precio'], 'safe'],
        ];
    }
    public function attributeLabels(){
        return [
            
        ];
    }
    public function create(){
        return DAOFactory::getDetalleDAO()->create($this);
    }
    public static function deleteByIdVenta($id){
        return DAOFactory::getDetalleDAO()->deleteByIdVenta($id);
    }
    
    public function update(){
        return DAOFactory::getDetalleDAO()->update($this);
    }
    public static function getByIdVentaView($id){
        return DAOFactory::getDetalleDAO()->getByIdVentaView($id);
    }
    public static function countById($id){
        return DAOFactory::getDetalleDAO()->countById($id);
    }
}
