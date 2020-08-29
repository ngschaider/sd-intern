<?php

namespace app\models;

use app\components\NotImplementedException;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 * @package app\models
 *
 * @property-read integer $id
 * @property string $username
 * @property string $password_hash
 * @property-read string $authKey
 * @property-read void $auth_key
 * @property boolean $allow_login
 * @property boolean $enabled
 */
class User extends ActiveRecord implements IdentityInterface {

	public $password;

	/**
	 * @param bool $insert
	 * @return bool
	 * @throws Exception
	 */
	public function beforeSave($insert) {
		if($this->password != "") {
			$this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
		}

		return parent::beforeSave($insert);
	}

	public static function tableName() {
		return "users";
	}

	public static function findIdentity($id) {
		return static::findOne($id);
	}

	public function __construct($config = []) {
		$this->scenario = "insert";

		parent::__construct($config);
	}

	public function afterFind() {
		$this->scenario = "update";

		return parent::beforeValidate();
	}

	public function rules() {
		return [
			[["username"], "required"],
			[["password"], "required", "except" => "update"],
			[["username", "password"], "string", "max" => 255],
			[["allow_login", "enabled"], "boolean"],
		];
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username) {
		return static::findOne(["username" => $username]);
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->getPrimaryKey();
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword($password, $this->password);
	}

	/**
	 * @param mixed $token
	 * @param null $type
	 * @return void|IdentityInterface|null
	 * @throws NotImplementedException
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		throw new NotImplementedException();
	}

	/**
	 * @return string|void
	 * @throws NotImplementedException
	 */
	public function getAuthKey() {
		throw new NotImplementedException();
	}

	/**
	 * @param string $authKey
	 * @return bool|void
	 * @throws NotImplementedException
	 */
	public function validateAuthKey($authKey) {
		throw new NotImplementedException();
	}

}
