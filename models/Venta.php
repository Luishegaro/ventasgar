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
class Venta extends Model
{
    public $id_venta;
    public $id_cliente;
    public $fecha;
    public $numero;
    public $nombre;
    public $placa;
    public $tipo;
    public $saldo;
    public $total;

    public $materiales;
    
    public $cancelado;
    public $_registrado;
    public $_usuario;
    public $_estado;
    public $observacion;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
            [['id_cliente', 'fecha','_usuario','_registrado','tipo','materiales'], 'required'],

            [['saldo','cancelado','numero','observacion','total'], 'safe'],
            [['id_cliente','numero'], 'integer'],
            [['materiales'], 'integer','min'=>1],
            [['total','saldo','cancelado'], 'number'],
        ];
    }
    public function attributeLabels(){
        return [
            'id_venta' => 'Numero',
            'id_cliente' => 'Cliente',
            'fecha' => 'Fecha',
            'numero' => 'No.',
            'tipo'=>'Tipo de cobro',
            'total'=>'Total',
            '_registrado' => 'Registrado',
            '_usuario' => 'Usuario',
            'observacion' => 'Observaciones',
        ];
    }

    public static function getVentasCredito(){
        return DAOFactory::getVentaDAO()->getVentasCredito();
    }
    public static function getTotalSaldo($id){
        return DAOFactory::getVentaDAO()->getTotalSaldo($id);
    }
    public static function getVentaByIdCliente($id){
        return DAOFactory::getVentaDAO()->getVentaByIdCliente($id);
    }
    
    public function create(){
        return DAOFactory::getVentaDAO()->create($this);
    }
    public static function getLastInsertedId(){
        return DAOFactory::getVentaDAO()->getLastInsertedId();
    }
    public function delete(){
        return DAOFactory::getVentaDAO()->delete($this);
    }
    public function update(){
        return DAOFactory::getVentaDAO()->update($this);
    }
    public static function getById($id_venta){
        $o = DAOFactory::getVentaDAO()->getById($id_venta);
        return !empty($o) ? new self($o) : NULL;
    }
    public static function getByIdView($id_venta){
        $o = DAOFactory::getVentaDAO()->getByIdView($id_venta);
        return !empty($o) ? new self($o) : NULL;
    }
    public static function countByIdCliente($id){
        return DAOFactory::getVentaDAO()->countByIdCliente($id);
    }
    public static function getVentasTotal(){
        return DAOFactory::getVentaDAO()->getVentasTotal();
    }
}
