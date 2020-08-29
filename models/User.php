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
 * @property string $password
 * @property-read string $authKey
 * @property-read void $auth_key
 */
class User extends ActiveRecord implements IdentityInterface {

	public function beforeSave($insert) {
		if(!parent::beforeSave($insert)) {
			return false;
		}

		if($this->isNewRecord) {
			$this->auth_key = Yii::$app->security->generateRandomString();
		}

		return true;
	}

	public static function tableName() {
		return "users";
	}

	public static function findIdentity($id) {
		return static::findOne($id);
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
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 * @throws Exception
	 */
	public function setPassword($password) {
		$this->password = Yii::$app->security->generatePasswordHash($password);
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
