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
class PagoForm extends Model
{
    public $id_pago;
    public $numero;
    public $pagado_a;
    public $fecha;
    public $concepto;
    public $tipo;
    public $monto;
    public $id_venta;
    public $id_cliente;
    public $_estado;
    public $_registrado;
    public $_usuario;
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
            [['pagado_a', 'fecha','tipo','monto','id_venta','id_cliente','_registrado','_usuario'], 'required'],
            [['id_pago','tipo','id_venta','id_cliente'], 'integer'],
            [['monto'], 'number'],
            [['fecha'], 'date'],
            [['_estado','concepto'], 'safe'],
            [['pagado_a','concepto'], 'trim'],
            
        ];
    }
    public function attributeLabels(){
        return [
            'numero'=>'Numero de Recibo',
            'id_cliente'=>'Cliente',
            'fecha'=>'Fecha',
            'monto'=>'Monto a Cancelar (Bs.)',
            'total_pagado'=>'Total Pagado',
            'saldo'=>'Saldo',
            '_registrado'=>'Registrado',
            '_usuario'=>'Usuario',
        ];
    }
    
    
    public function create(){
        return DAOFactory::getPagoDAO()->create($this);
    }
    public function update(){
        return DAOFactory::getPagoDAO()->update($this);
    }
    public function delete(){
        return DAOFactory::getPagoDAO()->delete($this);
    }
    public static function getTotalPagado($id){
        return DAOFactory::getPagoDAO()->getTotalPagado($id);
    }
    public static function getByIdView($id_pago){
        return DAOFactory::getPagoDAO()->getByIdView($id_pago);
    }
    public static function getLastInsertedId(){
        return DAOFactory::getPagoDAO()->getLastInsertedId();
    }
    public static function getById($id_pago){
        $o = DAOFactory::getPagoDAO()->getById($id_pago);
        return !empty($o) ? new self($o) : NULL;
    }
    public static function getAll()
    {
        return DAOFactory::getPagoDAO()->getAll();
    }
    public static function deleteByIdVenta($id){
        return DAOFactory::getPagoDAO()->deleteByIdVenta($id);
    }
    public static function countByIdCliente($id){
        return DAOFactory::getPagoDAO()->countByIdCliente($id);
    }
    public static function getSaldoByIdCliente($id){
        return DAOFactory::getPagoDAO()->getSaldoByIdCliente($id);
    }
    public static function getPagosByIdVenta($id){
        return DAOFactory::getPagoDAO()->getPagosByIdVenta($id);
    }
    
}
