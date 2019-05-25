<?php

namespace app\models\dao;

use Yii;
use yii\db\mssql\PDO;
use app\models\User;

class UsuarioDAO extends \yii\base\Object{

  public function getById($id){
    return Yii::$app->db->createCommand("
      SELECT username,password,auth_key, access_token,last_login_ip,last_login_at,email,fullname,rol
      FROM auth_user
      WHERE username = :ID
    ")->bindValue(':ID', $id)
    ->queryOne();
  }

  public function getByToken($token){
    return Yii::$app->db->createCommand("
      SELECT userame,password,auth_key, access_token,last_login_ip,last_login_at,rol
      FROM usuario
      WHERE access_token = :TOKEN
    ")->bindValue(':TOKEN', $token)
    ->queryOne();
  }

  public static function findUsuario($criterio){
    return Yii::$app->db->createCommand("
      SELECT username, fullname, email,rol
      FROM auth_user
      WHERE upper(username) like :CRITERIO
      OR upper(fullname) like :CRITERIO
      OR upper(email) like :CRITERIO
      ORDER BY fullname
    ")->bindValue(':CRITERIO', '%'.strtoupper($criterio).'%')
    ->queryAll();
  }

/**********adm usuario*************/
  public function deleteUser(User $usuario){
    return Yii::$app->db->createCommand()->delete('auth_user',
      ['username' => $usuario->username])->execute();
  }

  public function updateUser(User $usuario){
    return Yii::$app->db->createCommand()->update('auth_user',[
      'username' => $usuario->username,
      'password' => sha1($usuario['password']),
      'email' => $usuario['email'],
      'fullname' => $usuario['fullname'],
      'rol' => $usuario['rol'],
    ],['username' => $usuario->id])->execute();
  }


  public function createUser(User $usuario){
    return Yii::$app->db->createCommand()->insert('auth_user',[
      'username' => $usuario['username'],
      'password' => sha1($usuario['password']),
      'email' => $usuario['email'],
      'fullname'=>$usuario['fullname'],
      'rol'=>$usuario['rol'],
    ])->execute();
  }
  public function getAll(){
    return Yii::$app->db->createCommand("
      SELECT username,password,rol
      FROM auth_user
    ")->queryAll();
  }
  public function getByUsername($username){
    return Yii::$app->db->createCommand("
      SELECT username as id,username,password,rol
      FROM auth_user
      WHERE username = :USERNAME
    ")->bindValue(':USERNAME', $username)
    ->queryOne();
  }
}