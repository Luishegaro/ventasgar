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
class MaterialForm extends Model
{
    public $id_material;
    public $nombre;
    public $precio;
    public $_registrado;
    public $_usuario;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // nombre and precio are both required
            [['nombre', 'precio','_usuario','_registrado'], 'required'],
            [['nombre'], 'trim'],
            [['precio'],'number'],
            
        ];
    }
    public function attributeLabels(){
        return [
            'nombre' => 'Nombre',
            'precio' => 'Precio',
            '_registrado' => 'Registrado',
            '_usuario' => 'Usuario',
        ];
    }

    public static function getMaterialesByIdRecibo($id_recibo)
    {
        return DAOFactory::getMaterialDAO()->getByIdRecibo($id_recibo);
    }
    public static function getCantidadByCliente($id)
    {
        return DAOFactory::getMaterialDAO()->getCantidadByCliente($id);
    }
    public static function getMateriales()
    {
        return DAOFactory::getMaterialDAO()->getAll();
    }
    public function create(){
        return DAOFactory::getMaterialDAO()->create($this);
    }
    public function delete(){
        return DAOFactory::getMaterialDAO()->delete($this);
    }
    public function update(){
        return DAOFactory::getMaterialDAO()->update($this);
    }
    public static function getById($id_material){
        $o = DAOFactory::getMaterialDAO()->getById($id_material);
        return !empty($o) ? new self($o) : NULL;
    }
}
