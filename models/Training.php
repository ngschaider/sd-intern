<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use app\components\ActiveRecord;
use DateTime;
use DateTimeZone;
use Yii;
use yii\db\ActiveQuery;
use yii\db\DataReader;
use yii\helpers\ArrayHelper;

/**
 * Class Training
 *
 * @package app\models
 *
 * @property integer $id
 * @property string $start
 * @property string $end
 * @property-read Location $location
 * @property integer $locationId
 * @property-read User[] $users
 * @property integer $maxUsers
 * @property-read int $attendedCount
 * @property-read User[] $attendedUsers
 * @property-read float $attendedPercentage
 * @property-read void $notAttendedPercentage
 * @property-read int $notAttendedCount
 * @property-read UserTraining[] $userTrainings
 * @property-read DateTime $startObj
 * @property-read DateTime $endObj
 */
class Training extends ActiveRecord {

	public function rules() {
		return [
			[["start", "end"], "required"],
			[["maxUsers"], "integer"],
			[["start", "end"], "date", "format" => "php:Y-m-d H:i:s"],
			[["locationId"], "exist", "targetClass" => Location::class, "targetAttribute" => "id"],
		];
	}

	public function getStartObj() {
		$dt = new DateTime($this->start, new DateTimeZone("UTC"));
		$dt->setTimezone(new DateTimeZone(Yii::$app->timeZone));
		return $dt;
	}

	public function getEndObj() {
		$dt = new DateTime($this->end, new DateTimeZone("UTC"));
		$dt->setTimezone(new DateTimeZone(Yii::$app->timeZone));
		return $dt;
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

	public function getAttendedUsers() {
		return ArrayHelper::getColumn($this->getUserTrainings()->where(["attended" => true])->all(), "user");
	}

	public function getStartEndReadable() {
		$startDay = $this->startObj->format("l");
		$endDay = $this->endObj->format("l");

		$startDate = $this->startObj->format("d.m.Y");
		$endDate = $this->endObj->format("d.m.Y");

		$startTime = $this->startObj->format("H:i");
		$endTime = $this->endObj->format("H:i");

		$ret = $startDay . ", " . $startDate . " " . $startTime;
		if($startDate != $endDate) {
			$ret .= $endDay . " " . $endDate . " " . $endTime;
		} else if($startTime != $endTime) {
			$ret .= " - " . $endTime;
		}

		return $ret;
	}

	/**
	 * @param User $user
	 * @param bool $attended
	 * @return bool
	 */
	public function addUser($user, $attended = false) {
		foreach($this->userTrainings as $userTraining) {
			if($userTraining->userId == $user->id) {
				$userTraining->attended = $attended;
				return $userTraining->save();
			}
		}

		$userTraining = new UserTraining();
		$userTraining->attended = $attended;
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

		$end = date("Y-m-d H:i:s", $end);

		/** @var Training[] $trainings */
		$trainings = Training::find()->andWhere(["<=", "end", $end])->all();

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