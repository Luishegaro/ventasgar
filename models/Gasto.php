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
class Gasto extends Model
{
    public $id_gasto;
    public $numero;
    public $nro_factura;
    public $pagado_a;
    public $fecha;
    public $concepto;
    public $tipo;
    public $monto;
    public $id_activo;
    public $_estado;
    public $observacion;
    public $_registrado;
    public $_usuario;
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
            [['pagado_a', 'fecha','tipo','monto','_registrado','concepto','_usuario'], 'required'],
            [['id_gasto','nro_factura'], 'integer'],
            [['monto'], 'number'],
            [['fecha'], 'date'],
            [['id_activo'], 'integer'],
            [['nro_factura'], 'default'],
            [['_estado','observacion','id_activo'], 'safe'],
            [['pagado_a','concepto','nro_factura','observacion'], 'trim'],
            
        ];
    }
    public function attributeLabels(){
        return [
            'id_gasto'=>'Nro de Recibo',
            'pagado_a'=>'Pagado a',
            'fecha'=>'Fecha',
            'monto'=>'Monto a Cancelar (Bs.)',
            '_registrado'=>'Registrado',
            '_usuario'=>'Usuario',
        ];
    }
    
    
    public function create(){
        return DAOFactory::getGastoDAO()->create($this);
    }
    public function update(){
        return DAOFactory::getGastoDAO()->update($this);
    }
    public function delete(){
        return DAOFactory::getGastoDAO()->delete($this);
    }
    
    public static function getLastInsertedId(){
        return DAOFactory::getGastoDAO()->getLastInsertedId();
    }
    public static function getById($id){
        $o = DAOFactory::getGastoDAO()->getById($id);
        return !empty($o) ? new self($o) : NULL;
    }
    
}
