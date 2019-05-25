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
class ClienteForm extends Model
{
    public $id_cliente;
    public $placa;
    public $nombre;
    public $telefono;
    public $direccion;
    public $deuda;
    public $_registrado;
    public $_usuario;
    public $_estado;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // nombre and placa are both required
            [['nombre','_estado','_usuario','_registrado'], 'required'],
            [['nombre'], 'trim'],
           
            //
            [['deuda', 'telefono','direccion','placa'], 'safe'],
            
        ];
    }
    public function attributeLabels(){
        return [
            'nombre' => 'Nombre',
            'placa' => 'Placa',
            'direccion' => 'Dirección',
            'telefono' => 'Teléfono',
            'deuda' => 'Saldo',
            '_estado' => 'Estado',
            '_registrado' => 'Registrado',
            '_usuario' => 'Usuario',
        ];
    }

    
    public static function getClientes()
    {
        return DAOFactory::getCLienteDAO()->getAll();
    }
    public static function getLista()
    {
        return DAOFactory::getCLienteDAO()->getLista();
    }
    public function create(){
        return DAOFactory::getCLienteDAO()->create($this);
    }
    public function delete(){
        return DAOFactory::getCLienteDAO()->delete($this);
    }
    public function update(){
        return DAOFactory::getCLienteDAO()->update($this);
    }
    
    public static function getById($id_cliente){
        $o = DAOFactory::getCLienteDAO()->getById($id_cliente);
        return !empty($o) ? new self($o) : NULL;
    }
    public static function getClientesConDeuda()
    {
        return DAOFactory::getCLienteDAO()->getClientesConDeuda();
    }
}
