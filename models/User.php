<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\dao\DAOFactory;

class User extends Model implements \yii\web\IdentityInterface
{
    public $username;
    public $password;
    public $auth_key;
    public $access_token;
    public $last_login_ip;
    public $last_login_at;
    public $fullname;
    public $email;
    public $id;
    public $rol;

    public function rules()
    {
        return [
            [['username', 'password', 'fullname', 'email','rol'], 'required'],
            [['id'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Nombre de usuario',
            'fullname' => 'Nombre completo',
            'password' => 'Clave',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $o = DAOFactory::getUsuarioDAO()->getById($id);
        return !empty($o) ? new static($o) : NULL;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $u = DAOFactory::getUsuarioDAO()->getByToken($token);
        return !empty($u) ? new static($u) : NULL;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $u = DAOFactory::getUsuarioDAO()->getById($username);
        return !empty($u) ? new static($u) : NULL;
    }

    public static function find($criterio = '%'){ 
        return DAOFactory::getUsuarioDAO()->findUsuario($criterio);
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }
    public static function search($criterio = '%'){ 
        return DAOFactory::getUsuarioDAO()->searchUsuario($criterio);
    }

    public function getRoles(){
        return Yii::$app->authManager->getRolesByUser($this->id);
    }

    public function getPermisos(){
        return Yii::$app->authManager->getPermissionsByUser($this->id);   
    }

    public static function getRole($name){
        return Yii::$app->authManager->getRole($name);  
    }

    public function create(){
        return DAOFactory::getUsuarioDAO()->createUser($this);
    }

    public function update(){
        return DAOFactory::getUsuarioDAO()->updateUser($this);
    }

    public function delete(){
        return DAOFactory::getUsuarioDAO()->deleteUser($this);
    }

}
