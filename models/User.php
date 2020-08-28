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
 * @property-write string $password
 * @property-read void $authKey
 */
class User extends ActiveRecord implements IdentityInterface {

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
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 * @throws Exception
	 */
	public function validatePassword($password) {
		return $this->password_hash === Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 * @throws Exception
	 */
	public function setPassword($password) {
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	public static function findIdentityByAccessToken($token, $type = null) {
		throw new NotImplementedException();
	}

	public function getAuthKey() {
		throw new NotImplementedException();
	}

}
