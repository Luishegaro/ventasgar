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
class Reporte extends Model
{
    public $id_cliente;
    public $fecha_inicio;
    public $fecha_fin;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
            [['id_cliente', 'fecha_inicio','fecha_fin'], 'required'],

            [['fecha_inicio','fecha_fin'], 'date'],
            
        ];
    }
    public function attributeLabels(){
        return [
            'fecha_inicio' => 'Inicio',
            'id_cliente' => 'Clientes',
            'fecha_fin' => 'Fin',
            
        ];
    }

   
    public function getVentasByCliente(){
        return DAOFactory::getReporteDAO()->getVentasByCliente($this);
    }
    public function getResumen(){
        return DAOFactory::getReporteDAO()->getResumen($this);
    }
    public function getRecibos(){
        return DAOFactory::getReporteDAO()->getRecibos($this);
    }
    public static function getMaterialByFecha($fecha) {
        return DAOFactory::getVentaDAO()->getMateriales($fecha);
    }
    public function getResumenMateriales() {
        return DAOFactory::getReporteDAO()->getResumenMateriales($this);
    }
    public static function getMaterialByIdAndFecha($id,$fecha) {
        return DAOFactory::getReporteDAO()->getMaterialByIdAndFecha($id,$fecha);
    }
    
}
