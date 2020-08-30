<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use app\components\ActiveRecord;
use TrainingUser;

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
 * @property boolean $is_optional
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

	public function getUserTrainings() {
		return $this->hasMany(UserTraining::class, ["id" => "user_id"]);
	}

}