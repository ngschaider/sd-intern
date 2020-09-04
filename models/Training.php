<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use app\components\ActiveRecord;
use yii\db\ActiveQuery;
use yii\db\DataReader;

/**
 * Class Training
 *
 * @package app\models
 *
 * @property integer $id
 * @property integer $start
 * @property integer $end
 * @property-read Location $location
 * @property integer $locationId
 * @property-read User[] $users
 * @property boolean $isOptional
 * @property-read int $attendedCount
 * @property-read float $attendedPercentage
 * @property-read void $notAttendedPercentage
 * @property-read int $notAttendedCount
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

	/**
	 * @return int
	 */
	public function getAttendedCount() {
		return $this->getUserTrainings()->andWhere(["attended" => true])->count();
	}

	/**
	 * @return int
	 */
	public function getNotAttendedCount() {
		return $this->getUserTrainings()->andWhere(["attended" => false])->count();
	}

	public function getAttendedPercentage() {
		if(count($this->userTrainings) < 1) {
			return 1;
		}

		return $this->attendedCount / ($this->notAttendedCount + $this->attendedCount);
	}

	public function getNotAttendedPercentage() {
		if(count($this->userTrainings) < 1) {
			return 1;
		}

		return $this->notAttendedCount / ($this->notAttendedCount + $this->attendedCount);
	}

	/**
	 * @param null $end
	 * @return false|string|DataReader|null
	 */
	public static function getAttendancePercentage($end = null) {
		if($end === null) {
			$end = time();
		}
		$end = date("Y-m-d", $end);

		$trainings = Training::find()->andWhere("end <= :end", [
			":end" => $end,
		])->all();

		if(count($trainings) < 1) {
			return 0;
		}

		$sum = 0;
		foreach($trainings as $training) {
			$sum += $training->attendedPercentage;
		}

		return $sum / count($trainings);
	}

}