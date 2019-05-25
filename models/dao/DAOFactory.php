<?php

namespace app\models\dao;

use Yii;

class DAOFactory extends \yii\base\Object{

  public static function getClienteDAO(){
  	return new ClienteDAO();
  }
  public static function getMaterialDAO(){
  	return new MaterialDAO();
  }
  public static function getVentaDAO(){
  	return new VentaDAO();
  }
  public static function getDetalleDAO(){
  	return new DetalleDAO();
  }
  public static function getPagoDAO(){
    return new PagoDAO();
  }
  public static function getUsuarioDAO(){
    return new UsuarioDAO();
  }
  public static function getContadorDAO(){
    return new ContadorDAO();
  }
  public static function getGastoDAO(){
    return new GastoDAO();
  }
  public static function getReporteDAO(){
    return new ReporteDAO();
  }
}