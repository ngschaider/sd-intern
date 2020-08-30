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
 * @property string $name
 * @property-read mixed $location
 * @property-read ActiveQuery $users
 * @property boolean $is_optional
 * @property-read $userTrainings
 */
class Training extends ActiveRecord {

	public static function tableName() {
		return "trainings";
	}

	public function rules() {
		return [
			[["start", "end", "is_optional", "name"], "required"],
			[["name"], "string", "max" => 255],
			[["start", "end"], "date", "format" => "php:Y-m-d H:i:s"],
			[["location_id"], "exist", "targetClass" => Location::class, "targetAttribute" => "id"],
		];
	}

	public function getLocation() {
		return $this->hasOne(Location::class, ["id" => "location_id"]);
	}

	public function attributeLabels() {
		return [
			"location.name" => "Location",
		];
	}

	/**
	 * @return ActiveQuery
	 */
	public function getUserTrainings() {
		return $this->hasMany(UserTraining::class, ["training_id" => "id"]);
	}

}