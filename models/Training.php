<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use app\components\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Class Training
 *
 * @package app\models
 *
 * @property integer $id
 * @property integer $start
 * @property integer $end
 * @property-read mixed $location
 * @property integer $locationId
 * @property-read User[] $users
 * @property boolean $isOptional
 * @property-read UserTraining[] $userTrainings
 */
class Training extends ActiveRecord {

	public static function tableName() {
		return "trainings";
	}

	public function rules() {
		return [
			[["start", "end", "isOptional"], "required"],
			[["start", "end"], "date", "format" => "php:Y-m-d H:i:s"],
			[["locationId"], "exist", "targetClass" => Location::class, "targetAttribute" => "id"],
		];
	}

	/**
	 * @return ActiveQuery
	 */
	public function getLocation() {
		return $this->hasOne(Location::class, ["id" => "locationId"]);
	}

	/**
	 * @return ActiveQuery
	 */
	public function getUserTrainings() {
		return $this->hasMany(UserTraining::class, ["trainingId" => "id"]);
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function addUser($user) {
		foreach($this->userTrainings as $userTraining) {
			if($userTraining->userId == $user->id) {
				return false;
			}
		}

		$userTraining = new UserTraining();
		$userTraining->trainingId = $this->id;
		$userTraining->userId = $user->id;
		return $userTraining->save();
	}

	public function getAttendedCount() {
		return $this->getUserTrainings()->andWhere(["attended" => true])->count();
	}

	public function getNotAttendedCount() {
		return $this->getUserTrainings()->andWhere(["attended" => false])->count();
	}

}