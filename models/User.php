<?php

namespace app\models;

use app\components\NotImplementedException;
use Yii;
use yii\base\Exception;
use app\components\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 * @package app\models
 *
 * @property-read integer $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property string $passwordHash
 * @property boolean $allowLogin
 * @property-read bool $isAdmin
 * @property-read bool $isSuperadmin
 * @property-read User[] $createdUsers
 * @property-read User $createdByUser
 * @property-read UserTraining[] $userTrainings
 * @property-read void|string $authKey
 * @property-read integer $attendedCount
 * @property-read integer $notAttendedCount
 * @property-read float[] $attendancePercentages
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
			$this->passwordHash = Yii::$app->security->generatePasswordHash($this->password);
		}

		return parent::beforeSave($insert);
	}

	public static function findIdentity($id) {
		return static::findOne($id);
	}

	public function getIsSuperadmin() {
		return $this->id == 1;
	}

	public function getIsAdmin() {
		return $this->isSuperadmin;
	}

	public function rules() {
		return [
			[["username", "allowLogin"], "required"],
			[["username"], "unique"],
			[["username", "firstname", "lastname", "password"], "string", "max" => 255],
			[["allowLogin"], "boolean"],
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
		return Yii::$app->security->validatePassword($password, $this->passwordHash);
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

	public function getUserTrainings() {
		return $this->hasMany(UserTraining::class, ["userId" => "id"]);
	}

	public function getAttendedCount() {
		return $this->getUserTrainings()->andWhere(["attended" => true])->count();
	}

	public function getNotAttendedCount() {
		return $this->getUserTrainings()->andWhere(["attended" => false])->count();
	}

	/**
	 * Returns the percentage of attended trainings for this user
	 *
	 * @param null $end timestamp to which trainings should be considered.
	 * @return float
	 */
	public function getAttendancePercentage($end = null) {
		if($end === null) {
			$end = time();
		}

		$trainings = [];
		foreach($this->userTrainings as $userTraining) {
			if($userTraining->training->end) {
				if(strtotime($userTraining->training->end) <= $end) {
					$trainings[] = $userTraining->training;
				}
			}
		}

		if(count($trainings) < 1) {
			return 0;
		}

		$sum = 0;
		foreach($trainings as $training) {
			$sum += $training->attendedPercentage;
		}

		return $sum / count($trainings);
	}

	/**
	 * Returns an array containing the attendance percentage for every training
	 *
	 * @return float[] keys contains the end of the training, values the attendance percentage
	 */
	public function getAttendancePercentages() {
		$ret = [];
		foreach($this->userTrainings as $userTraining) {
			if(strtotime($userTraining->training->start) > time()) {
				continue;
			}
			$timestamp = strtotime($userTraining->training->end);
			$ret[$timestamp] = $this->getAttendancePercentage($timestamp);
		}

		return $ret;
	}

}
